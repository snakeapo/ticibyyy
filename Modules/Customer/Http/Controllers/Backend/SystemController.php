<?php

namespace Modules\Customer\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Stocks;
use App\Models\User;
use App\Models\Withs;
use Modules\Customer\Http\Requests\Backend\UserCreateRequest;
use Modules\Customer\Http\Requests\Backend\UserUpdateRequest;
use Modules\Customer\Http\Requests\Backend\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SystemController extends Controller
{

    //User
/* ================================================================ */

    //User list
    public function user_list()
    {
        $data = User::where('role','user')->get();
        return view('customer::backend.items.user.user',compact('data'));
    }

    //Admin list
    public function admin_list()
    {
        $data = User::where('role','admin')->get();
        return view('customer::backend.items.user.admin',compact('data'));
    }


    //User insert
    public function user_insert()
    {
        return view('customer::backend.items.user.insert');
    }

    //User Edit
    public function user_edit($id)
    {
        $data = User::findOrFail($id);
        return view('customer::backend.items.user.edit',compact('data'));
    }

    //User create
    public function user_create(UserCreateRequest $request)
    {
        $formData = $request->validated();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/user'), $fileName);
        }

        if ($request->password_confirm != $request->password) {
            return redirect()->back()->with('error', 'Şifreler Uyuşmuyor!');
        }


        $identy = date('his')*rand(999,99999);

        $formData['password'] = Hash::make($request->password);
        $formData['avatar'] = $fileName;
        $formData['identy'] = $identy;
        $formData['balance'] = 0;
        $insert = User::create($formData);
        return back()->with('success','Ekleme İşlemi Başarılı!');
    }

    //User update
    public function user_update(UserUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $user = User::findOrFail($id);
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
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }

    //Pasword change
    public function change_password(ChangePasswordRequest $request,$id)
    {

        $request->validated();

        $user = User::findOrFail($id);

        if ($request->password_confirm != $request->password) {
            return redirect()->back()->with('error', 'Şifreler Uyuşmuyor!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Şifre Başarıyla Güncellendi!');
    }

    //User delete
    public function user_delete($id)
    {
        $user = User::findOrFail($id);
        $oldFilePath = public_path('/upload/user/' . $user->avatar);
        if ($user->avatar && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $user->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ================================================================ */

    //Notify Stock
/* ================================================================ */

    //Stock page
    public function stock_notify()
    {
        $data = Stocks::all();
        return view('customer::backend.items.user.stock',compact('data'));
    }

    //Stock delete
    public function stock_notify_delete($id)
    {
        $stock = Stocks::findOrFail($id);
        $stock->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }


/* ================================================================ */

    //Withdraw
/* ================================================================ */

    //Withdraw
    public function withdraw()
    {
        $data = Withs::all();
        return view('customer::backend.items.user.with',compact('data'));
    }

    //Withdraw okay
    public function withdraw_okay($id)
    {
        $update = Withs::where('id',$id)->update([
            "status" => 1,
        ]);
        return back()->with('success','Onaylama İşlemi Başarılı!');
    }

    //Withdraw reject
    public function withdraw_reject($id)
    {
        $with = Withs::findOrFail($id);

        DB::transaction(function () use ($with) {
            $with->update([
                "status" => 2,
            ]);

            $user = User::findOrFail($with->user_id);
            $user->update([
                'balance' => $user->balance + $with->total,
            ]);
        });

        return back()->with('success','Reddetme İşlemi Başarılı!');
    }


    //Withdraw delete
    public function withdraw_delete($id)
    {
        $with = Withs::findOrFail($id);
        $with->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }


/* ================================================================ */


}
