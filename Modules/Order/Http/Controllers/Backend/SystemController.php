<?php

namespace Modules\Order\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Orderitems;
use App\Models\Orders;
use App\Models\Address;
use App\Models\Baskets;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\NotificationPreferenceMailer;

class SystemController extends Controller
{
    public function __construct(private NotificationPreferenceMailer $notificationPreferenceMailer)
    {
    }

    //Order
/* ================================================================= */

    //Pending
    public function pending_order()
    {
        $data = Orders::where('status',0)->get();
        return view('order::backend.items.order.pending',compact('data'));
    }

    //Complated
    public function completed_order()
    {
        $data = Orders::where('status',1)->get();
        return view('order::backend.items.order.completed',compact('data'));
    }

    //Prepared
    public function prepared_order()
    {
        $data = Orders::where('status',2)->get();
        return view('order::backend.items.order.prepared',compact('data'));
    }

    //Shipping
    public function shipped_order()
    {
        $data = Orders::where('status',3)->get();
        return view('order::backend.items.order.shipped',compact('data'));
    }

    //Cancel
    public function cancel_order()
    {
        $data = Orders::where('status',4)->get();
        return view('order::backend.items.order.cancel',compact('data'));
    }


    //Live Basket
    public function live_basket()
    {
        $data = Baskets::with(['user', 'items.getProduct'])
            ->whereHas('items')
            ->latest('updated_at')
            ->get();

        return view('order::backend.items.order.basket', compact('data'));
    }

    //Detail
    public function order_detail($id)
    {
        $data = Orders::findOrFail($id);
        $items = Orderitems::where('order_token',$data->order_no)->get();
        $address = Address::where('id', $data->user_address)->orWhere('address_token', $data->user_address)->first();
        return view('order::backend.items.order.detail',compact('data','items','address'));
    }

    //Order Status
    public function order_status(Request $request,$order_no)
    {
        $order = Orders::where('order_no',$order_no)->first();
        Orders::where('order_no',$order_no)->update(['status' => $request->status]);
        if ($order && $order->user_id) {
            $user = User::where('id', $order->user_id)->where('notify_order_updates', true)->first();
            if ($user) {
                $this->notificationPreferenceMailer->sendToUsers(collect([$user]), 'Sipariş durumunuz güncellendi', 'Siparişinizin durumu güncellendi.', route('user_order_detail', $order_no));
            }
        }
        return back()->with('success','İşlem Başarılı!');
    }

    //Delete
    public function order_delete($id)
    {
        $data = Orders::findOrFail($id);
        $items = Orderitems::where('order_token',$data->order_no)->delete();
        $data->delete();
        return back()->with('success','Sipariş Silindi!');
    }

/* ================================================================= */
}
