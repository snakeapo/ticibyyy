<?php

namespace Modules\Page\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use App\Models\Pages;
use Illuminate\Http\Request;
use Modules\Page\Http\Requests\Frontend\ContactPostRequest;

class MasterController extends Controller
{

    //Page
/* ============================================================ */

    //Detail
    public function page_detail($page_slug)
    {
        $data = Pages::where('page_slug',$page_slug)->first();
        return view('page::frontend.page.detail',compact('data'));
    }

    //Contact
    public function contact_page()
    {
        return view('page::frontend.page.contact');
    }

    //Contact post
    public function contact_post(ContactPostRequest $request)
    {
        $formData = $request->validated();
        $formData['status'] = "0";
        $insert = Messages::create($formData);
        return back()->with('success','Mesajınız Tarafımıza İletildi!');
    }

/* ============================================================ */

}
