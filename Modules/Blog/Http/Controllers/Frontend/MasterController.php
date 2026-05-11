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
        $query = Blogs::latest();

        // normal pagination
        $blogs = $query->paginate(10);

        $featuredPost = null;
        $sidePosts = collect();

        // sadece ilk sayfada featured alanı çalışsın
        if (request()->get('page', 1) == 1) {

            // ilk 4 kayıt
            $featuredItems = Blogs::latest()->take(4)->get();

            // en son kayıt
            $featuredPost = $featuredItems->first();

            // diğer 3 kayıt
            $sidePosts = $featuredItems->slice(1);

            // grid kısmında tekrar görünmesinler
            $excludeIds = $featuredItems->pluck('id');

            $blogs = Blogs::latest()
                ->whereNotIn('id', $excludeIds)
                ->paginate(10);
        }

        return view('blog::frontend.blog.index', compact(
            'blogs',
            'featuredPost',
            'sidePosts'
        ));
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
        $category = Blogcats::where('category_slug', $category_slug)->firstOrFail();

        $featuredPost = null;
        $sidePosts = collect();

        // base query
        $query = Blogs::where('category_id', $category->id)
            ->latest();

        // default grid
        $blogs = $query->paginate(10);

        // sadece ilk sayfa
        if (request()->get('page', 1) == 1) {

            // son 4 post
            $featuredItems = Blogs::where('category_id', $category->id)
                ->latest()
                ->take(4)
                ->get();

            // büyük post
            $featuredPost = $featuredItems->first();

            // sağdaki 3
            $sidePosts = $featuredItems->slice(1);

            // tekrar görünmesin
            $excludeIds = $featuredItems->pluck('id');

            $blogs = Blogs::where('category_id', $category->id)
                ->whereNotIn('id', $excludeIds)
                ->latest()
                ->paginate(10);
        }

        return view('blog::frontend.blog.category', compact(
            'category',
            'blogs',
            'featuredPost',
            'sidePosts'
        ));
    }

/* ======================================================= */

}
