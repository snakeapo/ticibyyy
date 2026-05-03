<?php

namespace Modules\Blog\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blogcats;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Modules\Blog\Http\Requests\Backend\BlogCategoryInsertRequest;
use Modules\Blog\Http\Requests\Backend\BlogCategoryUpdateRequest;
use Modules\Blog\Http\Requests\Backend\BlogCreateRequest;
use Modules\Blog\Http\Requests\Backend\BlogUpdateRequest;
use Illuminate\Support\Str;

class SystemController extends Controller
{

    //Blog categories
/* ============================================================== */

    //category
    public function blog_category_list()
    {
        $data = Blogcats::all();
        return view('blog::backend.items.blog.blog-category',compact('data'));
    }

    //category create
    public function blog_category_insert(BlogCategoryInsertRequest $request)
    {
        $formData = $request->validated();

        if (strlen($request->category_title)>3)
        {
            $slug=Str::slug($request->category_title);
        } else {
            $slug=Str::slug($request->category_title);
        }

        $formData['category_slug'] = $slug;

        $insert = Blogcats::create($formData);
        return back()->with('success','Kayıt İşlemi Başarılı');
    }

    //category update
    public function blog_category_update(BlogCategoryUpdateRequest $request,$id)
    {
        $formData = $request->validated();

        $category = Blogcats::findOrFail($id);

        if (strlen($request->category_title)>3)
        {
            $slug=Str::slug($request->category_title);
        } else {
            $slug=Str::slug($request->category_title);
        }

        $formData['category_slug'] = $slug;
        $category->update($formData);
        return back()->with('success','Düzenleme İşlemi Başarılı!');
    }

    //category delete
    public function blog_category_delete($id)
    {
        $find = Blogcats::findOrFail($id);
        $productUpdate = Blogs::where('blog_category',$id)->update([
            "blog_category" => 0,
        ]);

        $find->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }


/* ============================================================== */

    //Blog
/* ======================================================================= */

    //Blog List
    public function blog_list()
    {
        $data = Blogs::all();
        return view('blog::backend.items.blog.index',compact('data'));
    }

    //Blog insert
    public function blog_insert()
    {
        return view('blog::backend.items.blog.insert');
    }

    //Blog edit
    public function blog_edit($id)
    {
        $data = Blogs::findOrFail($id);
        return view('blog::backend.items.blog.edit',compact('data'));
    }

    //Blog create
    public function blog_create(BlogCreateRequest $request)
    {

        $formData = $request->validated();


        if (strlen($request->blog_title)>3)
        {
            $slug=Str::slug($request->blog_title);
        } else {
            $slug=Str::slug($request->blog_title);
        }


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/blog'), $fileName);
        }

        $formData['image'] = $fileName;
        $formData['blog_slug'] = $slug;
        $insert = Blogs::create($formData);
        return back()->with('success','Kayıt İşlemi Başarılı!');

    }

    //Blog update
    public function blog_update(BlogUpdateRequest $request,$id)
    {

        $formData = $request->validated();

        $blog = Blogs::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('/upload/blog'), $fileName);

            $oldFilePath = public_path('/upload/blog/' . $blog->image);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $formData['image'] = $fileName;
        }

        if (strlen($request->blog_title)>3)
        {
            $slug=Str::slug($request->blog_title);
        } else {
            $slug=Str::slug($request->blog_title);
        }

        $formData['blog_slug'] = $slug;
        $blog->update($formData);
        return back()->with('success','Düzenleme İşlemi Başarılı!');

    }

    //Blog delete
    public function blog_delete($id)
    {
        $find = Blogs::findOrFail($id);
        $oldFilePath = public_path('/upload/blog/' . $find->image);
        if ($find->image && file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }
        $find->delete();
        return back()->with('success','Silme İşlemi Başarılı!');
    }

/* ======================================================================= */



}
