<?php

namespace Modules\Category\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Subcategories;

class MasterController extends Controller
{
    public function index()
    {
        $categories = Categories::with([
            'subcategories' => function ($q) {
                $q->whereNull('parent_id') // sadece ana sub
                ->with('childrenx');      // altını da çek
            }
        ])->get();

        return view('category::frontend.index', compact('categories'));
    }
    // Top Category
    public function top_category_detail($slug)
    {
        $data = Categories::where('category_slug', $slug)->firstOrFail();

        return redirect()->route('product_filter', ['category' => $data->id]);
    }
    public function sub_parent_category_detail($topSlug, $subSlug)
    {
        $top = Categories::where('category_slug', $topSlug)->firstOrFail();

        $sub = Subcategories::where('sub_slug', $subSlug)
            ->where('top_category', $top->id)
            ->whereNull('parent_id')
            ->firstOrFail();

        return redirect()->route('product_filter', [
            'category' => $top->id,
            'subcategory' => $sub->id,
        ]);
    }
    // Sub Category
    public function sub_category_detail($topSlug, $subSlug, $childSlug)
    {
        // Top category
        $top = Categories::where('category_slug', $topSlug)->firstOrFail();

        // Sub (parent)
        $sub = Subcategories::where('sub_slug', $subSlug)
            ->where('top_category', $top->id)
            ->whereNull('parent_id')
            ->firstOrFail();

        // Child (asıl kategori)
        $child = Subcategories::where('sub_slug', $childSlug)
            ->where('parent_id', $sub->id)
            ->firstOrFail();

        return redirect()->route('product_filter', [
            'category' => $top->id,
            'subcategory' => $sub->id,
            'childCategory' => $child->id,
        ]);
    }
}
