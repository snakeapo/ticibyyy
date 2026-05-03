<?php

namespace Modules\Blog\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blogcats;
use App\Models\Blogs;
use Illuminate\Http\Request;

class MasterController extends Controller
{

    //Blog
/* ======================================================= */

    //Blog list
    public function blog_page()
    {
        $data = Blogs::paginate(10);
        return view('blog::frontend.blog.index',compact('data'));
    }

    //Blog detail
    public function blog_detail($blog_slug)
    {
        $data = Blogs::where('blog_slug',$blog_slug)->first();
        return view('blog::frontend.blog.detail',compact('data'));
    }

    //Blog category
    public function blog_category_detail($category_slug)
    {
        $category = Blogcats::where('category_slug',$category_slug)->first();
        $data = Blogs::where('blog_category',$category->id)->paginate(10);
        return view('blog::frontend.blog.category',compact('category','data'));
    }

/* ======================================================= */

}
