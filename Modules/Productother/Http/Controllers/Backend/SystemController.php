<?php

namespace Modules\Productother\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Askques;
use App\Models\Baskets;
use App\Models\Brands;
use App\Models\Basketvars;
use App\Models\Coupons;
use App\Models\Images;
use App\Models\Ordervars;
use App\Models\Productcoms;
use App\Models\Products;
use App\Models\Productvars;
use Carbon\Carbon;
use App\Models\User;
use App\Services\NotificationPreferenceMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Productother\Http\Requests\Backend\ProductImageCreateRequest;
use Modules\Productother\Http\Requests\Backend\ProductImageUpdateRequest;
use Modules\Productother\Http\Requests\Backend\ProductVariantUpdateRequest;
use Modules\Productother\Http\Requests\Backend\CouponCreateRequest;
use Modules\Productother\Http\Requests\Backend\CouponUpdateRequest;
use Modules\Productother\Http\Requests\Backend\BrandCreateRequest;
use Modules\Productother\Http\Requests\Backend\BrandUpdateRequest;
use Modules\Productother\Http\Requests\Backend\CommentUpdateRequest;
use Modules\Productother\Http\Requests\Backend\QuestionAnswerRequest;

class SystemController extends Controller
{
    public function __construct(private NotificationPreferenceMailer $notificationPreferenceMailer)
    {
    }



    // Brand list
    public function brand_list()
    {
        $data = Brands::paginate(10);
        return view('productother::backend.items.product.other.brand', compact('data'));
    }

    // Brand create
    public function brand_create(BrandCreateRequest $request)
    {
        $formData = $request->validated();
        $formData['brand_slug'] = \Illuminate\Support\Str::slug($request->brand_title);

        if ($request->hasFile('brand_image')) {
            File::ensureDirectoryExists(public_path('/upload/brand'));
            $file = $request->file('brand_image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/upload/brand'), $fileName);
            $formData['brand_image'] = $fileName;
        }

        Brands::create($formData);

        return back()->with('success', 'Kayıt İşlemi Başarılı');
    }
    public function brand_edit($id)
    {
        $data = Brands::paginate(10);
        $find = Brands::findOrFail($id);


        return view('productother::backend.items.product.other.brand-edit', compact('find','data'));
    }
    // Brand update
    public function brand_update(BrandUpdateRequest $request, $id)
    {
        $formData = $request->validated();

        $brand = Brands::findOrFail($id);
        $formData['brand_slug'] = \Illuminate\Support\Str::slug($request->brand_title);

        if ($request->hasFile('brand_image')) {
            File::ensureDirectoryExists(public_path('/upload/brand'));
            $file = $request->file('brand_image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/upload/brand'), $fileName);

            $oldFilePath = public_path('/upload/brand/' . $brand->brand_image);
            if ($brand->brand_image && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['brand_image'] = $fileName;
        }

        $brand->update($formData);

        return back()->with('success', 'Düzenleme İşlemi Başarılı!');
    }

    // Brand delete
    public function brand_delete($id)
    {
        $find = Brands::findOrFail($id);

        Products::where('brand', $id)->update([
            'brand' => null,
        ]);

        $oldFilePath = public_path('/upload/brand/' . $find->brand_image);
        if ($find->brand_image && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        $find->delete();

        return redirect()->route('brand_list')->with('success', 'Silme İşlemi Başarılı!');
    }

/* ======================================================================= */

    //Image
/* ======================================================================= */

    //Product image
    public function product_image($id)
    {
        $data = Products::findOrFail($id);
        $image = Images::where('product_id', $data->id)->get();
        return view('productother::backend.items.product.image',compact('data','image'));
    }

    //Product image post
    public function product_image_create(ProductImageCreateRequest $request,$token)
    {
        $formData = $request->validated();
        $product = Products::where('product_token', $token)->firstOrFail();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/product'), $fileName);
        }

        $formData['image'] = $fileName;
        $formData['product_id'] = $product->id;
        $formData['product_token'] = $token;

        $insert = Images::create($formData);
        return back()->with('success','Ekleme İşlemi Başarılı!');
    }

    //Product image update
    public function product_image_update(ProductImageUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $image = Images::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/product'), $fileName);

            $oldFilePath = public_path('/upload/product/' . $image->image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['image'] = $fileName;
        }

        $image->update($formData);
        return back()->with('success','Düzenleme İşlemi Başarılı!');
    }

    //Product image delete
    public function product_image_delete($id)
    {
        $image = Images::findOrFail($id);
        $oldFilePath = public_path('/upload/product/' . $image->image);
        if ($image->image && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $image->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ======================================================================= */


    //Variant
/* ======================================================================= */

    //Product variant
    public function product_variant($id)
    {
        $product = Products::findOrFail($id);
        $data = Productvars::where('product_id', $product->id)->get();
        return view('productother::backend.items.product.variant',compact('product','data'));
    }

    public function variant_stock_alerts()
    {
        $criticalLimit = (int) request('limit', 3);
        if ($criticalLimit < 0) {
            $criticalLimit = 3;
        }

        $variants = Productvars::with('product')
            ->where('variant_stock', '<=', $criticalLimit)
            ->orderBy('variant_stock')
            ->orderByDesc('id')
            ->get();

        return view('productother::backend.items.product.variant-alert', compact('variants', 'criticalLimit'));
    }

    //Product variant insert
    public function product_variant_create(Request $request,$token)
    {
        $product = Products::where('product_token', $token)->firstOrFail();


        $variantNames = $request->input('variant_name', []);
        $variantTypes = $request->input('variant_type', []);
        $parentVariantTypes = $request->input('parent_variant_type', []);
        $parentVariantNames = $request->input('parent_variant_name', []);
        $variantPrices = $request->input('variant_price', []);
        $variantStocks = $request->input('variant_stock', []);
        $variantImages = $request->file('variant_image', []);
        $isColors = $request->input('is_color', []);


        foreach ($variantNames as $key => $variantName) {
            if (isset($variantPrices[$key]) && isset($variantStocks[$key])) {
            $normalizedParentVariantName = collect(explode(',', (string) ($parentVariantNames[$key] ?? '')))
                ->map(fn ($name) => trim($name))
                ->filter()
                ->implode(', ');

            $variant = new Productvars;
            $variant->product_id = $product->id;
            $variant->product_token = $token;
            $variant->variant_name = $variantName;
            $variant->variant_type = $variantTypes[$key] ?? 'Genel';
            $variant->parent_variant_type = $parentVariantTypes[$key] ?? null;
            $variant->parent_variant_name = $normalizedParentVariantName ?: null;
            $variant->variant_price = $variantPrices[$key];
            $variant->variant_stock = $variantStocks[$key];
                $variant->is_color = $isColors[$key] ?? null;
            if (array_key_exists($key, $variantImages) && $variantImages[$key]) {
                $imageName = time() . '_' . $variantImages[$key]->getClientOriginalName();
                $variantImages[$key]->move(public_path('upload/product'), $imageName);
                $variant->variant_image = $imageName;
            }

            $variant->save();
        }
        }
        return back()->with('success','Kayıt İşlemi Başarılı!');
    }

    //Product variant update
    public function product_variant_update(ProductVariantUpdateRequest $request,$id)
    {

        $formData = $request->validated();
        $formData['parent_variant_name'] = collect(explode(',', (string) ($formData['parent_variant_name'] ?? '')))
            ->map(fn ($name) => trim($name))
            ->filter()
            ->implode(', ') ?: null;

        $variant = Productvars::findOrFail($id);

        if ($request->hasFile('variant_image')) {
            $file = $request->file('variant_image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/product'), $fileName);

            $oldFilePath = public_path('/upload/product/' . $variant->variant_image);
            if ($variant->variant_image && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['variant_image'] = $fileName;
            }

        $variant->update($formData);
        return back()->with('success','Düzenleme İşlemi Başarılı!');

    }


    //Product variant delete
    public function product_variant_delete($id)
    {
        $variant = Productvars::findOrFail($id);
        Basketvars::where('variant_id',$id)->delete();
        Ordervars::where('variant_token',$id)->delete();
        $oldFilePath = public_path('/upload/product/' . $variant->variant_image);
        if ($variant->variant_image && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $variant->delete();

        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ======================================================================= */


    //Coupon
/* ======================================================================= */

    //Coupon list
    public function coupon_list()
    {
        $data = Coupons::all();
        return view('productother::backend.items.product.other.coupon',compact('data'));
    }

    //Coupon create page
    public function coupon_create_page()
    {
        return view('productother::backend.items.product.other.coupon-create');
    }

    //Coupon edit page
    public function coupon_edit_page($id)
    {
        $coupon = Coupons::findOrFail($id);
        return view('productother::backend.items.product.other.coupon-edit', compact('coupon'));
    }

    //Coupon create
    public function coupon_create(CouponCreateRequest $request)
    {
        $formData = $request->validated();
        $formData['coupon_code'] = Str::upper(trim($formData['coupon_code']));


        Coupons::create($formData);
        $this->notificationPreferenceMailer->sendToUsers(User::where('notify_coupon_updates', true)->get(), 'Yeni kupon tanımlandı', 'Yeni bir kupon tanımlandı, hesabınızı kontrol edin.');
        return back()->with('success', 'Kayıt İşlemi Başarılı');
    }

    //Coupon update
    public function coupon_update(CouponUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $coupon = Coupons::findOrFail($id);
        $formData['coupon_code'] = Str::upper(trim($formData['coupon_code']));



        $coupon->update($formData);
        return back()->with('success','Düzenleme İşlemi Başarılı!');
    }

    //Coupon delete
    public function coupon_delete($id)
    {
        $coupon = Coupons::findOrFail($id);
        Baskets::where('coupon_id', $id)->update([
            'coupon_id' => null,
        ]);

        $coupon->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ======================================================================= */

    //Comment
/* ======================================================================= */

    //Comment List
    public function comment_list()
    {
        $data = Productcoms::all();
        return view('productother::backend.items.product.other.comment',compact('data'));
    }

    //Comment update
    public function comment_update(CommentUpdateRequest $request,$id)
    {
        $formData = $request->validated();
        $comment = Productcoms::findOrFail($id);
        $formData['answer_time'] = Carbon::now();
        $comment->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }

    //Comment okay
    public function comment_okay($id)
    {
        $update = Productcoms::where('id',$id)->update([
            "status" => 1,
        ]);
        return back()->with('success','Onaylama İşlemi Başarılı!');
    }

    //Comment reject
    public function comment_reject($id)
    {
        $update = Productcoms::where('id',$id)->update([
            "status" => 2,
        ]);
        return back()->with('success','Reddetme İşlemi Başarılı!');
    }

    //Comment update
    public function comment_delete($id)
    {
        $comment = Productcoms::findOrFail($id);
        $comment->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ======================================================================= */


    //Question
/* ======================================================================= */

    //Ques List
    public function question_list()
    {
        $data = Askques::all();
        return view('productother::backend.items.product.other.question',compact('data'));
    }

    //Ques update
    public function question_answer(QuestionAnswerRequest $request,$id)
    {
        $formData = $request->validated();
        $ques = Askques::findOrFail($id);
        $formData['answer_time'] = Carbon::now();
        $formData['status'] = 1;
$ques->update($formData);
        if ($ques->user_id) {
            $user = User::where('id', $ques->user_id)->where('notify_question_answers', true)->first();
            if ($user) {
                $this->notificationPreferenceMailer->sendToUsers(collect([$user]), 'Sorunuza cevap geldi', 'Sorduğunuz soruya cevap verildi.');
            }
        }
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }


    //Ques update
    public function question_delete($id)
    {
        $ques = Askques::findOrFail($id);
        $ques->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ======================================================================= */



}
