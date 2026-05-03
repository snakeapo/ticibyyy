<?php

namespace Modules\Customer\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Coupons;
use App\Models\Favories;
use App\Models\Orderitems;
use App\Models\Orders;
use App\Models\Productcoms;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Customer\Http\Requests\Frontend\UserPostRequest;
use Modules\Customer\Http\Requests\Frontend\PasswordChangeUserRequest;
use Modules\Customer\Http\Requests\Frontend\AddressStoreRequest;
use Modules\Customer\Http\Requests\Frontend\AddressUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class MasterController extends Controller
{

    //User
/* ==================================================== */

    //User panel
    public function user_panel()
    {
        return view('customer::frontend.user.panel');
    }

    //User post
    public function user_post(UserPostRequest $request)
    {
        $formData = $request->validated();

        $user = User::findOrFail(Auth::user()->id);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/user'), $fileName);

            $oldFilePath = public_path('/upload/user/' . $user->avatar);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['avatar'] = $fileName;
        }

        $user->update($formData);
        return back()->with('success','Profil Düzenlemesi Başarılı!');
    }


    //Password
    public function password_change()
    {
        return view('customer::frontend.user.password');
    }
    public function password_change_user(PasswordChangeUserRequest $request)
    {

        $request->validated();

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Eski şifreniz yanlış');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Şifreniz Değiştirildi');
    }

    //Favories
    public function favories_page()
    {
        $data = Favories::where('user_id',Auth::user()->id)->get();
        return view('customer::frontend.user.favories',compact('data'));
    }

    public function my_address()
    {
        $data = Address::where('user_id',Auth::user()->id)->get();
        return view('customer::frontend.user.address',compact('data'));
    }

    public function new_address(AddressStoreRequest $request)
    {
        $formData = $request->validated();
        $formData['user_id'] = Auth::id();
        $formData['address_token'] = rand(999,99999);
        Address::create($formData);

        return back()->with('success', 'Adres başarıyla eklendi.');
    }

    public function update_address(AddressUpdateRequest $request, $id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $address->update($request->validated());

        return back()->with('success', 'Adres başarıyla güncellendi.');
    }

    public function delete_address($id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $address->delete();

        return back()->with('success', 'Adres başarıyla silindi.');
    }

    public function notice_setting()
    {
        return view('customer::frontend.user.notification');
    }

    public function notice_setting_update(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $user->update([
            'notify_new_products' => $request->boolean('notify_new_products'),
            'notify_stock_updates' => $request->boolean('notify_stock_updates'),
            'notify_order_updates' => $request->boolean('notify_order_updates'),
            'notify_coupon_updates' => $request->boolean('notify_coupon_updates'),
            'notify_price_drops' => $request->boolean('notify_price_drops'),
            'notify_question_answers' => $request->boolean('notify_question_answers'),
            'notify_abandoned_cart' => $request->boolean('notify_abandoned_cart'),
        ]);

        return back()->with('success', 'Bildirim tercihleriniz güncellendi.');
    }

    public function  my_coupon()
    {
        $data = Coupons::where('status',1)->where('hide',1)->where('coupon_quantity','>',0)->paginate(10);
        return view('customer::frontend.user.coupon',compact('data'));
    }

    //Order
    public function order_detail($order_token)
    {
        $data = Orders::where('order_no',$order_token)->first();
        $items = Orderitems::where('order_token',$data->order_no)->get();
        return view('customer::frontend.user.order',compact('data','items'));
    }

    //Commnet
    public function comment_insert(Request $request)
    {
        $productTokens = $request->input('product_token', []);
        $points = $request->input('point', []);
        $comments = $request->input('comment', []);
        $images = $request->file('image', []);

        foreach ($productTokens as $key => $productToken) {
            $product = Products::where('product_token', $productToken)->first();
            if (!$product) {
                continue;
            }
            $comment = new Productcoms;
            $comment->product_id = $product->id;
            $comment->product_token = $productToken;
            $comment->point = $points[$key];
            $comment->comment = $comments[$key];
            $comment->user_id = Auth::user()->id;
            if (array_key_exists($key, $images) && $images[$key]) {
                $imageName = time() . '_' . $images[$key]->getClientOriginalName();
                $images[$key]->move(public_path('upload/comment'), $imageName);
                $comment->image = $imageName;
            }
            $comment->save();
        }

        $update = Orders::where('order_no',$request->order)->update([
            'comment' => 1,
        ]);


        return back()->with('success','Değerlendirme yapıldı, teşekkürler!');
    }

/* ==================================================== */

}
