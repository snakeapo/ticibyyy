<?php

namespace Modules\Product\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pasts;
use App\Models\Brands;
use App\Models\Productcoms;
use App\Models\Products;
use App\Models\Ranges;
use App\Models\Stocks;
use Illuminate\Http\Request;
use Modules\Product\Http\Requests\Frontend\StokBildirRequest;

class MasterController extends Controller
{

    // Brand detail
    public function brand_detail($slug)
    {
        $data = Brands::where('brand_slug', $slug)->firstOrFail();

        return redirect()->route('product_filter', ['brand' => $data->id]);
    }

    public function all_brand()
    {
        $data = Brands::orderBy('id','desc')->get();
        return view('product::frontend.product.all-brand', compact('data'));
    }

    // Detail
    public function product_detail($slug)
    {
        $slugParts = explode('-', $slug);
        $productToken = end($slugParts);

        $data = Products::where('product_token', $productToken)
            ->where('status', 1)
            ->firstOrFail();

        $existingRecord = Pasts::where('ip_address', $_SERVER['REMOTE_ADDR'])
            ->where('product_id', $data->id)
            ->first();

        if (!$existingRecord) {
            Pasts::create([
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'product_id' => $data->id,
                'product_token' => $data->product_token,
            ]);
        }

        return view('product::frontend.product.detail', compact('data'));
    }

    public function product_detail_comment($slug)
    {
        $slugParts = explode('-', $slug);
        $productToken = end($slugParts);

        $find = Products::where('product_token', $productToken)->firstOrFail();

    }

    // Search Product
    public function product_search(Request $request)
    {
        $searchTerm = $request->input('q');

        $products = Products::where('title', 'like', '%' . $searchTerm . '%')
            ->orWhere('product_token', $searchTerm)
            ->paginate(12);

        return view('product::frontend.product.search', ['product' => $products, 'term' => $searchTerm]);
    }

    // Puan
    public static function calculateAverageRating($productId)
    {
        $averageRating = Productcoms::where('status', 1)->where('product_id', $productId)->avg('point');
        return round($averageRating);
    }

    // Stok bildirim
    public function stok_bildir(StokBildirRequest $request, $product_token)
    {
        $formData = $request->validated();
        $product = Products::where('product_token', $product_token)->firstOrFail();

        $formData['product_id'] = $product->id;
        $formData['product_token'] = $product_token;
        Stocks::create($formData);
        return back()->with('success', 'Bildiriminiz Tarafımıza İletilmiştir!');
    }

    // Filtre
    public function product_filter(Request $request)
    {
        return view('product::frontend.product.filtre', [
            'category' => $request->integer('category') ?: null,
            'subcategory' => $request->integer('subcategory') ?: null,
            'childCategory' => $request->integer('childCategory') ?: null,
            'brand' => $request->integer('brand') ?: null,
            'q' => trim((string) $request->input('q', '')) ?: null,
        ]);
    }
}
