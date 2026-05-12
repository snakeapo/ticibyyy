<?php

namespace Modules\Page\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Annons;
use App\Models\Customers;
use App\Models\Messages;
use App\Models\Pages;
use App\Models\Sliders;
use Illuminate\Http\Request;
use Modules\Page\Http\Requests\Backend\PageCreateRequest;
use Modules\Page\Http\Requests\Backend\PageUpdateRequest;
use Modules\Page\Http\Requests\Backend\SliderCreateRequest;
use Modules\Page\Http\Requests\Backend\SliderUpdateRequest;
use Modules\Page\Http\Requests\Backend\AnnonsCreateRequest;
use Modules\Page\Http\Requests\Backend\AnnonsUpdateRequest;
use Modules\Page\Http\Requests\Backend\CustomerCommentCreateRequest;
use Modules\Page\Http\Requests\Backend\CustomerCommentUpdateRequest;
use Illuminate\Support\Str;

class SystemController extends Controller
{
    //Message
/* ========================================================== */

    //Message list
    public function message_list()
    {
        $data = Messages::all();
        return view('page::backend.items.other.message',compact('data'));
    }

    //Message delete
    public function message_read($id)
    {
        $message = Messages::where('id',$id)->update([
            'status' => 1,
        ]);
        return back()->with('success','Mesaj Okundu!');
    }

    //Message delete
    public function message_delete($id)
    {
        $message = Messages::findOrFail($id);
        $message->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ========================================================== */


    //Page
/* ========================================================== */

    //Page list
    public function page_list()
    {
        $data = Pages::all();
        return view('page::backend.items.page.page',compact('data'));
    }

    //Page insert
    public function page_insert()
    {
        return view('page::backend.items.page.insert');
    }

    //Page edit
    public function page_edit($id)
    {
        $data = Pages::find($id);
        return view('page::backend.items.page.edit',compact('data'));
    }

    //Page create
    public function page_create(PageCreateRequest $request)
    {
        $formData = $request->validated();

        if (strlen($request->page_title)>3)
        {
            $slug=Str::slug($request->page_title);
        } else {
            $slug=Str::slug($request->page_title);
        }

        $formData['page_slug'] = $slug;
        $insert = Pages::create($formData);
        return back()->with('success','Kayıt İşlemi Başarılı!');
    }

    //Page edit
    public function page_update(PageUpdateRequest $request, $id)
    {
        if (in_array($id, [1, 2, 3, 4])) {
            return back()->with('error', 'Bu sayfa düzenlenemez!');
        }

        $formData = $request->validated();

        $page = Pages::findOrFail($id);

        $slug = Str::slug($request->page_title);

        $formData['page_slug'] = $slug;

        $page->update($formData);

        return back()->with('success', 'Güncelleme İşlemi Başarılı!');
    }


// Page delete
    public function page_delete($id)
    {
        if (in_array($id, [1, 2, 3, 4])) {
            return back()->with('error', 'Bu sayfa silinemez!');
        }

        $page = Pages::findOrFail($id);

        $page->delete();

        return back()->with('success', 'Silme İşlemi Başarılı!');
    }

/* ========================================================== */


    //Slider
/* ========================================================== */

    //Slider list
    public function slider_list()
    {
        $data = Sliders::all();
        return view('setting::backend.items.other.slider',compact('data'));
    }

    //Slider create
    public function slider_create(SliderCreateRequest $request)
    {
        $formData = $request->validated();

        if ($request->hasFile('slider_image')) {
            $file = $request->file('slider_image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/slider'), $fileName);
        }else{
            $fileName = 0;
        }

        $formData['slider_image'] = $fileName;
        $insert = Sliders::create($formData);
        return back()->with('success','Kayıt İşlemi Başarılı!');
    }

    //Slider edit
    public function slider_update(SliderUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $slider = Sliders::findOrFail($id);

        if ($request->hasFile('slider_image')) {
            $file = $request->file('slider_image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/slider'), $fileName);

            $oldFilePath = public_path('/upload/slider/' . $slider->slider_image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['slider_image'] = $fileName;
        }

        $slider->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }

    //Slider delete
    public function slider_delete($id)
    {
        $slider = Sliders::findOrFail($id);
        $oldFilePath = public_path('/upload/slider/' . $slider->slider_image);
        if ($slider->slider_image && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $slider->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ========================================================== */


    //Annons
/* ========================================================== */

    //Annons list
    public function annons_list()
    {
        $data = Annons::all();
        return view('setting::backend.items.other.annons',compact('data'));
    }

    //Annons create
    public function annons_create(AnnonsCreateRequest $request)
    {
        $formData = $request->validated();

        $insert = Annons::create($formData);
        return back()->with('success','Kayıt İşlemi Başarılı!');
    }

    //Annons edit
    public function annons_update(AnnonsUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $annons = Annons::findOrFail($id);

        $annons->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');
    }

    //Annons delete
    public function annons_delete($id)
    {
        $annons = Annons::findOrFail($id);
        $annons->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }


/* ========================================================== */

    //Annons
/* ========================================================== */

    //Annons list
    public function customer_comment_list()
    {
        $data = Customers::all();
        return view('customer::backend.items.other.customer',compact('data'));
    }

    //Annons create
    public function customer_comment_create(CustomerCommentCreateRequest $request)
    {
        $formData = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/customer'), $fileName);
        }else{
            $fileName = 0;
        }

        $formData['image'] = $fileName;

        $insert = Customers::create($formData);
        return back()->with('success','Kayıt İşlemi Başarılı!');
    }

    //Annons edit
    public function customer_comment_update(CustomerCommentUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $customer = Customers::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/customer'), $fileName);

            $oldFilePath = public_path('/upload/customer/' . $customer->image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['image'] = $fileName;
        }

        $customer->update($formData);
        return back()->with('success','Güncelleme İşlemi Başarılı!');;
    }

    //Annons delete
    public function customer_comment_delete($id)
    {
        $customer = Customers::findOrFail($id);
        $oldFilePath = public_path('/upload/customer/' . $customer->image);
        if ($customer->image && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $customer->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }


/* ========================================================== */

}
