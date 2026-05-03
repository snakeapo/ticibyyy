<?php

namespace Modules\Order\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Banks;
use App\Models\Basketitems;
use App\Models\Baskets;
use App\Models\Cargos;
use App\Models\Coupons;
use App\Models\CouponUsage;
use App\Models\Orderitems;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Productvars;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Order\Http\Requests\Frontend\OrderPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MasterController extends Controller
{
    //Basket
/* ============================================================= */

    //Basket Cart POST
    public function cart_insert(Request $request, $product_token)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
            'variant' => ['nullable', 'integer'],
            'coupon' => ['nullable', 'string', 'max:255'],
        ]);

        $find = Products::where('product_token', $product_token)->firstOrFail();

        $variant = $this->resolveVariant($find->id, $validated['variant'] ?? null);
        $this->ensureVariantSelectionIfRequired($find, $variant);

        $basket = Baskets::firstOrCreate(
            ['user_id' => Auth::id()],
            ['basket_token' => date('his') * rand(999, 999999)]
        );

        $basketQuery = Basketitems::where('product_id', $find->id)
            ->where('user_id', Auth::id())
            ->where('variant', $validated['variant'] ?? null);

        $basketFind = $basketQuery->first();

        $findCp = null;
        $couponDiscount = 0;

        if (!empty($validated['coupon'])) {
            $findCp = Coupons::whereRaw('UPPER(coupon_code) = ?', [strtoupper(trim($validated['coupon']))])
                ->where('status', 1)
                ->where('coupon_quantity', '>=', 1)
                ->whereIn('coupon_scope', ['product', 'both'])
                ->first();

            if (!$findCp) {
                return back()->with('error', 'Kupon Geçersiz veya ürün için kullanılamaz!');
            }

            if ($this->hasUserUsedCoupon(Auth::id(), (int) $findCp->id)) {
                return back()->with('error', 'Bu kuponu daha önce kullandınız, tekrar kullanılamaz.');
            }
        }

        DB::transaction(function () use ($basketFind, $validated, $find, $product_token, $variant, $basket, $findCp) {
            $existingQty = $basketFind ? (int) $basketFind->quantity : 0;
            $requestedQty = (int) $validated['quantity'];
            $targetQty = $existingQty + $requestedQty;
            $this->assertStockAvailable($find, $variant, $targetQty);

            if (!$basketFind) {
                $basketFind = Basketitems::create([
                    'user_id' => Auth::id(),
                    'product_id' => $find->id,
                    'product_token' => $product_token,
                    'variant' => $variant?->id,
                    'old_total' => '0',
                    'total' => '0',
                    'quantity' => (string) $validated['quantity'],
                    'coupon' => $findCp?->id,
                    'basket_no' => $basket->basket_token,
                ]);

                if ($findCp) {
                    $findCp->decrement('coupon_quantity');
                }
            } else {
                $basketFind->quantity = (string) (((int) $basketFind->quantity) + ((int) $validated['quantity']));
                $basketFind->save();
            }

            $this->recalculateBasketItem($basketFind->refresh());
        });

        return redirect()->route('shopping_cart')->with('success', 'Ürün sepete eklendi!');
    }

    //Cart
    public function shopping_cart()
    {
        $userId = Auth::id();
        $data = Basketitems::where('user_id', $userId)->get();
        $basket = Baskets::where('user_id', $userId)->first();

        $subTotal = (float) $data->sum(fn ($item) => (float) $item->total);
        $cartCoupon = $basket?->coupon;
        $cartDiscount = 0;

        if ($cartCoupon && $cartCoupon->status == 1) {
            $cartDiscount = $cartCoupon->getDiscountAmount($subTotal);
        }

        $grandTotal = max($subTotal - $cartDiscount, 0);

        return view('order::frontend.order.cart', compact('data', 'basket', 'subTotal', 'cartDiscount', 'grandTotal', 'cartCoupon'));
    }

    public function cart_apply_coupon(Request $request)
    {
        $request->validate([
            'coupon' => ['required', 'string'],
        ]);

        $basket = Baskets::where('user_id', Auth::id())->first();
        if (!$basket) {
            return back()->with('error', 'Önce sepetinize ürün eklemelisiniz!');
        }

        $coupon = Coupons::whereRaw('UPPER(coupon_code) = ?', [strtoupper(trim($request->coupon))])
            ->where('status', 1)
            ->where('coupon_quantity', '>=', 1)
            ->whereIn('coupon_scope', ['cart', 'both'])
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Kupon geçersiz veya sepet için kullanılamaz!');
        }

        if ($this->hasUserUsedCoupon(Auth::id(), (int) $coupon->id)) {
            return back()->with('error', 'Bu kuponu daha önce kullandınız, tekrar kullanılamaz.');
        }

        DB::transaction(function () use ($basket, $coupon) {
            if ($basket->coupon_id && (int) $basket->coupon_id !== (int) $coupon->id) {
                $oldCoupon = Coupons::find($basket->coupon_id);
                if ($oldCoupon) {
                    $oldCoupon->increment('coupon_quantity');
                }
            }

            if ((int) $basket->coupon_id !== (int) $coupon->id) {
                $coupon->decrement('coupon_quantity');
            }

            $basket->update(['coupon_id' => $coupon->id]);
        });

        return back()->with('success', 'Sepet kuponu başarıyla uygulandı!');
    }

    public function cart_remove_coupon()
    {
        $basket = Baskets::where('user_id', Auth::id())->first();
        if (!$basket || !$basket->coupon_id) {
            return back()->with('warning', 'Aktif bir sepet kuponu bulunamadı.');
        }

        DB::transaction(function () use ($basket) {
            $coupon = Coupons::find($basket->coupon_id);
            if ($coupon) {
                $coupon->increment('coupon_quantity');
            }

            $basket->update(['coupon_id' => null]);
        });

        return back()->with('success', 'Sepet kuponu kaldırıldı.');
    }

    //Cart Approval
    public function cart_approval()
    {
        $user = Auth::user();
        $orderToken = date('His') * rand(999, 999999);
        $findBasket = Baskets::where('user_id', $user->id)->first();
        $findBasketItems = Basketitems::where('user_id', $user->id)->get();

        if (!$findBasket || $findBasketItems->count() === 0) {
            return back()->with('error', 'Sepetiniz boş, sipariş oluşturulamaz.');
        }

        $subTotal = (float) Basketitems::where('user_id', $user->id)->sum('total');
        $cartCoupon = $findBasket?->coupon;
        $cartDiscount = $cartCoupon ? $cartCoupon->getDiscountAmount($subTotal) : 0;
        $basketSum = max($subTotal - $cartDiscount, 0);

        DB::transaction(function () use ($findBasketItems, $orderToken, $user, $basketSum, $findBasket) {
            $this->assertCartStockBeforeOrder($findBasketItems);

            foreach ($findBasketItems as $take) {
                Orderitems::create([
                    'product_token' => $take->product_token,
                    'product_id' => $take->product_id,
                    'user_id' => $user->id,
                    'order_token' => $orderToken,
                    'variant_token' => $take->variant,
                    'total' => $take->total,
                    'quantity' => $take->quantity,
                ]);
            }

            $order = Orders::create([
                'user_id' => $user->id,
                'order_no' => $orderToken,
                'status' => '0',
                'total' => $basketSum,
            ]);

            $usedCouponIds = $findBasketItems->pluck('coupon')->filter()->map(fn ($id) => (int) $id)->unique()->values();
            if ($findBasket->coupon_id) {
                $usedCouponIds->push((int) $findBasket->coupon_id);
            }

            foreach ($usedCouponIds->unique() as $usedCouponId) {
                CouponUsage::firstOrCreate([
                    'user_id' => $user->id,
                    'coupon_id' => $usedCouponId,
                ], [
                    'order_id' => $order->id,
                    'order_no' => (string) $orderToken,
                ]);
            }

            if ($findBasket->coupon_id) {
                $coupon = Coupons::find($findBasket->coupon_id);
                if ($coupon) {
                    $coupon->increment('coupon_quantity');
                }
            }

            Basketitems::where('basket_no', $findBasket->basket_token)->delete();
            $findBasket->delete();
        });

        return redirect()->route('order_approval', $orderToken)->with('success', 'Sepet Onaylandı, Lütfen Siparişi Tamamlayın!');
    }

    //increase
    public function cart_increase($id)
    {
        $find = Basketitems::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $product = Products::findOrFail($find->product_id);
        $variant = $find->variant
            ? Productvars::where('id', $find->variant)->where('product_token', $product->product_token)->first()
            : null;
        $this->assertStockAvailable($product, $variant, ((int) $find->quantity) + 1);

        $find->quantity = (string) (((int) $find->quantity) + 1);
        $find->save();
        $this->recalculateBasketItem($find);

        return back()->with('success', 'Ürün adedi arttırıldı!');
    }

    //decrease
    public function cart_decrease($id)
    {
        $find = Basketitems::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $findBasket = Baskets::where('basket_token', $find->basket_no)->first();

        if ($find->quantity == 1) {
            $this->releaseItemCoupon($find);
            $find->delete();
            if ($findBasket && Basketitems::where('basket_no', $findBasket->basket_token)->count() == 0) {
                if ($findBasket->coupon_id) {
                    $coupon = Coupons::find($findBasket->coupon_id);
                    if ($coupon) {
                        $coupon->increment('coupon_quantity');
                    }
                }
                $findBasket->delete();
            }
            return back()->with('success', 'Ürün Sepetten Kaldırıldı!');
        }

        $find->quantity = (string) (((int) $find->quantity) - 1);
        $find->save();
        $this->recalculateBasketItem($find);
        return back()->with('success', 'Ürün adedi azaltıldı!');
    }

    //Delete
    public function cart_delete_product($id)
    {
        $item = Basketitems::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $basket = Baskets::where('basket_token', $item->basket_no)->first();
        $this->releaseItemCoupon($item);
        $item->delete();
        if ($basket && Basketitems::where('basket_no', $basket->basket_token)->count() === 0) {
            if ($basket->coupon_id) {
                $coupon = Coupons::find($basket->coupon_id);
                if ($coupon) {
                    $coupon->increment('coupon_quantity');
                }
            }
            $basket->delete();
        }
        return back()->with('success', 'Ürün Sepetten Kaldırıldı!');
    }

/* ============================================================= */

    //Order
/* ============================================================= */

    public function order_approval($order_token)
    {
        $data = Orders::where('order_no', $order_token)->where('user_id', Auth::id())->firstOrFail();
        $items = Orderitems::with(['getProduct', 'getVariant'])
            ->where('user_id', Auth::user()->id)
            ->where('order_token', $data->order_no)
            ->get();
        $cargos = Cargos::where('status', 1)->orderBy('id')->get();

        if ($cargos->isEmpty()) {
            $cargos = Cargos::orderBy('id')->get();
        }

        $invalidItemMessage = $this->findInvalidOrderItemMessage($items);
        if ($invalidItemMessage) {
            return redirect()->route('shopping_cart')->with('error', $invalidItemMessage);
        }

        return view('order::frontend.order.order', compact('data', 'items', 'cargos'));
    }

    public function order_post(OrderPostRequest $request,$order_token)
    {
        $validated = $request->validated();

        $formData = [
            'address_title' => $validated['address_title'],
            'city' => $validated['city'],
            'town' => $validated['town'],
            'address' => $validated['address'],
            'postal_code' => $validated['postal_code'],
            'phone' => $validated['phone'],
        ];

        $updateForm = [
            'cargo' => $validated['cargo'],
            'payment_system' => $validated['payment_system'],
            'order_note' => $validated['order_note'] ?? null,
        ];


        $order_token = $order_token;
        $findOrder = Orders::where('order_no',$order_token)->where('user_id', Auth::id())->firstOrFail();
        $updateOrder = Orders::where('id',$findOrder->id)->first();
        $orderItems = Orderitems::with(['getProduct', 'getVariant'])
            ->where('user_id', Auth::id())
            ->where('order_token', $findOrder->order_no)
            ->get();
        $invalidItemMessage = $this->findInvalidOrderItemMessage($orderItems);
        if ($invalidItemMessage) {
            return back()->withInput()->with('error', $invalidItemMessage);
        }
        $this->assertOrderStockBeforeFinalize($orderItems);

        $tokenAddress = date('His')*rand(999,99999);
        $formData['address_token'] = $tokenAddress;
        $formData['user_id'] = Auth::user()->id;
        $insert = Address::create($formData);
        $findCargo = Cargos::where('id',$request->cargo)->firstOrFail();
        $toplamTutar = $findOrder->total+$findCargo->cargo_price;

        $updateForm['total'] = $toplamTutar;
        $updateForm['user_address'] = $tokenAddress;
        $updateForm['payment_status'] = "0";
        $updateOrder->update($updateForm);

/* ================================================================ */

            //Banka Transfer
        if($request->payment_system == 1){

        return redirect()->route('order_complated',$order_token);

/* ================================================================ */

            //Kapıda Ödeme
        }elseif($request->payment_system == 2){
        return redirect()->route('order_complated',$order_token);

/* ================================================================ */

            //Paytr
        }elseif($request->payment_system == 3){

            $user = User::where('id',Auth::user()->id)->first();

            $findPaytr = Settings::where('id',1)->first();

            $merchant_id 	= $findPaytr->paytr_id;
            $merchant_key 	= $findPaytr->paytr_key;
            $merchant_salt	= $findPaytr->paytr_salt;

            $email = $user->email;
            $payment_amount	= $toplamTutar*100;
            $merchant_oid = $order_token;
            $user_name = $user->name;
            $user_address = $request->address;
            $user_phone = $user->user_phone;
            $merchant_ok_url = env('APP_URL','/siparis-tamamlandi',$order_token); //paytr callback tarafında aynı url olmayacak hataya sebep olur
            $merchant_fail_url = env('APP_URL','/siparis-basarisiz',$order_token);
            $user_basket = base64_encode(json_encode(array("Yeni Siparis", $toplamTutar, 1)));

            ## Kullanıcının IP adresi
            if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }


            $user_ip=$ip;

            $timeout_limit = "30";
            $debug_on = 1;
            $test_mode = 1;
            $no_installment	= 0;
            $max_installment = 0;

            $currency = "TL";

            ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
            $hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
            $paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
            $post_vals=array(
                    'merchant_id'=>$merchant_id,
                    'user_ip'=>$user_ip,
                    'merchant_oid'=>$merchant_oid,
                    'email'=>$email,
                    'payment_amount'=>$payment_amount,
                    'paytr_token'=>$paytr_token,
                    'user_basket'=>$user_basket,
                    'debug_on'=>$debug_on,
                    'no_installment'=>$no_installment,
                    'max_installment'=>$max_installment,
                    'user_name'=>$user_name,
                    'user_address'=>$user_address,
                    'user_phone'=>$user_phone,
                    'merchant_ok_url'=>$merchant_ok_url,
                    'merchant_fail_url'=>$merchant_fail_url,
                    'timeout_limit'=>$timeout_limit,
                    'currency'=>$currency,
                    'test_mode'=>$test_mode
                );

            $ch=curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1) ;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);



            $result = @curl_exec($ch);

            if(curl_errno($ch))
                die("PAYTR IFRAME connection error. err:".curl_error($ch));

            curl_close($ch);

            $result=json_decode($result,1);

            if($result['status']=='success')
            $token=$result['token'];
        else
            die("PAYTR IFRAME failed. reason:".$result['reason']);

                $orders = Orders::where('order_no',$order_token)->first();
                $orderitems = Orderitems::where('order_token',$order_token)->get();
                return view('order::frontend.order.paytr',compact('token'));

        }

    }

    public function odeme_basarili(Request $request)
    {

        if(!$request->has('merchant_oid') && !$request->has('status') && !$request->has('total_amount')) { exit("OK"); }


        $post = $_REQUEST;

        $findPaytr = Settings::where('id',1)->first();

        ####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
        #
        ## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
        $merchant_key 	= $findPaytr->paytr_key;
        $merchant_salt	= $findPaytr->paytr_salt;

        ###########################################################################

        ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
        #
        ## POST değerleri ile hash oluştur.
        $hash = base64_encode(hash_hmac('sha256', $post['merchant_oid'] . $merchant_salt . $post['status'] . $post['total_amount'], $merchant_key, true));
        if (!isset($post['hash']) || !hash_equals($hash, (string) $post['hash'])) {
            exit('PAYTR notification failed: bad hash');
        }
        #

        //burada paytrden dönen tokeni alıyorum bakiye tabloma eşleştiriyorum
        $find = \App\Models\Orders::where('order_no',$post['merchant_oid'])->first();
        if (!$find) {
            exit('OK');
        }



        if( $post['status'] == 'success' ) { ## Ödeme Onaylandı

            //işlem başarılı ile işlemimi yapıyorum
         $update = Orders::where('order_no',$post['merchant_oid'])->update([
                "payment_status" => 1,

            ]);

        } else { ## Ödemeye Onay Verilmedi

        }

        ## Bildirimin alındığını PayTR sistemine bildir.
        echo "OK";
        exit;

    }


    public function order_complated($order_token)
    {
        $data = Orders::where('order_no',$order_token)->where('user_id', Auth::id())->firstOrFail();
        $items = Orderitems::where('user_id',Auth::user()->id)->where('order_token',$data->order_no)->get();
        $banks = Banks::where('status',1)->get();
        return view('order::frontend.order.complated',compact('data','items','banks'));
    }

    public function order_cancelled($order_token)
    {
        $data = Orders::where('order_no',$order_token)->where('user_id', Auth::id())->firstOrFail();
        $items = Orderitems::where('user_id',Auth::user()->id)->where('order_token',$data->order_no)->get();
        return view('order::frontend.order.error',compact('data','items'));
    }

    public function invoice($order_token)
    {
        $data = Orders::where('order_no',$order_token)->firstOrFail();
        $items = Orderitems::where('order_token',$data->order_no)->get();
        $address = Address::where('address_token',$data->user_address)->first();
        return view('order::backend.items.order.invoice',compact('data','items','address'));
    }

    private function resolveVariant(int $productId, ?int $variantId): ?Productvars
    {
        if (!$variantId) {
            return null;
        }

        return Productvars::where('id', $variantId)
            ->where('product_token', Products::where('id', $productId)->value('product_token'))
            ->firstOrFail();
    }

    private function ensureVariantSelectionIfRequired(Products $product, ?Productvars $variant): void
    {
        $hasVariant = Productvars::where('product_token', $product->product_token)->exists();
        if ($hasVariant && !$variant) {
            throw ValidationException::withMessages([
                'variant' => 'Bu ürün için varyant seçimi zorunludur.',
            ]);
        }
    }

    private function assertStockAvailable(Products $product, ?Productvars $variant, int $requestedQty): void
    {
        if ($variant) {
            $stock = (int) $variant->variant_stock;
            if ($stock < $requestedQty) {
                throw ValidationException::withMessages([
                    'stock' => "\"{$variant->variant_name}\" varyantında yeterli stok yok. Kalan stok: {$stock}.",
                ]);
            }
            return;
        }

        $stock = (int) $product->stock;
        if ($stock < $requestedQty) {
            throw ValidationException::withMessages([
                'stock' => "Ürün stokta yeterli değil. Kalan stok: {$stock}.",
            ]);
        }
    }

    private function assertCartStockBeforeOrder($basketItems, bool $decreaseStock = false): void
    {
        foreach ($basketItems as $item) {
            $product = Products::lockForUpdate()->findOrFail($item->product_id);
            $variant = null;
            if ($item->variant) {
                $variant = Productvars::where('id', $item->variant)
                    ->where('product_token', $product->product_token)
                    ->lockForUpdate()
                    ->first();
                if (!$variant) {
                    throw ValidationException::withMessages(['stock' => 'Sepetteki varyant artık geçerli değil.']);
                }
            }

            $quantity = (int) $item->quantity;
            $this->assertStockAvailable($product, $variant, $quantity);

            if ($decreaseStock) {
                if ($variant) {
                    $variant->decrement('variant_stock', $quantity);
                } else {
                    $product->decrement('stock', $quantity);
                }
            }
        }
    }

    private function assertOrderStockBeforeFinalize($orderItems): void
    {
        foreach ($orderItems as $item) {
            $product = Products::find($item->product_id);
            if (!$product) {
                throw ValidationException::withMessages([
                    'stock' => 'Sepetteki ürün artık bulunamadı. Lütfen sepetinizi güncelleyip tekrar deneyin.',
                ]);
            }
            $variant = null;
            if ($item->variant_token) {
                $variant = Productvars::where('id', $item->variant_token)
                    ->where('product_token', $product->product_token)
                    ->first();
                if (!$variant) {
                    throw ValidationException::withMessages(['stock' => 'Siparişteki varyant artık geçerli değil.']);
                }
            }
            $this->assertStockAvailable($product, $variant, (int) $item->quantity);
        }
    }

    private function findInvalidOrderItemMessage($orderItems): ?string
    {
        foreach ($orderItems as $item) {
            if (!$item->getProduct) {
                return 'Sepetteki ürünlerden biri artık mevcut değil. Lütfen sepetinizi güncelleyip tekrar deneyin.';
            }

            if ($item->variant_token && !$item->getVariant) {
                return 'Sepetteki varyantlardan biri artık geçerli değil. Lütfen ürünü tekrar sepete ekleyin.';
            }
        }

        return null;
    }

    private function recalculateBasketItem(Basketitems $item): void
    {
        $product = Products::findOrFail($item->product_id);
        $variantPrice = 0;
        if ($item->variant) {
            $variant = Productvars::where('id', $item->variant)
                ->where('product_token', $product->product_token)
                ->first();
            if (!$variant) {
                throw ValidationException::withMessages(['variant' => 'Sepetteki varyant geçersiz.']);
            }
            $variantPrice = (float) $variant->variant_price;
        }

        $unitPrice = (float) ($product->sale_price != 0 ? $product->sale_price : $product->price) + $variantPrice;
        $lineSubTotal = $unitPrice * (int) $item->quantity;
        $discount = 0;
        if ($item->coupon) {
            $coupon = Coupons::find($item->coupon);
            if ($coupon && $coupon->status == 1 && in_array($coupon->coupon_scope, ['product', 'both'], true)) {
                $discount = $coupon->getDiscountAmount($lineSubTotal);
            }
        }
        $lineTotal = max(0, $lineSubTotal - $discount);

        $item->update([
            'old_total' => (string) $lineSubTotal,
            'total' => (string) $lineTotal,
        ]);
    }

    private function hasUserUsedCoupon(int $userId, int $couponId): bool
    {
        return CouponUsage::where('user_id', $userId)->where('coupon_id', $couponId)->exists();
    }

    private function releaseItemCoupon(Basketitems $item): void
    {
        if (!$item->coupon) {
            return;
        }

        $coupon = Coupons::find($item->coupon);
        if ($coupon) {
            $coupon->increment('coupon_quantity');
        }
    }

/* ============================================================= */



}
