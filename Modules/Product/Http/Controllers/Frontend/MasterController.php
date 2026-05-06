<?php

namespace Modules\Product\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Askques;
use App\Models\Cargos;
use App\Models\Pasts;
use App\Models\Brands;
use App\Models\Productcoms;
use App\Models\ProductRelatedProduct;
use App\Models\Products;
use App\Models\Ranges;
use App\Models\Stocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $type = "product";
        $slugParts = explode('-', $slug);
        $productToken = end($slugParts);

        $data = Products::where('product_token', $productToken)
            ->where('status', 1)
            ->firstOrFail();

        $cargo = Cargos::get();

        // ✅ Yorumları çek
        $reviews = \App\Models\Productcoms::where('product_token', $productToken)
            ->where('status', '1')
            ->get();

        $totalReviews = $reviews->count();
        $avgRating = $reviews->avg('point') ?? 0;

        // ✅ Yıldız dağılımı
        $ratings = [
            5 => $reviews->where('point', 5)->count(),
            4 => $reviews->where('point', 4)->count(),
            3 => $reviews->where('point', 3)->count(),
            2 => $reviews->where('point', 2)->count(),
            1 => $reviews->where('point', 1)->count(),
        ];

        // Kullanıcı giriş yaptıysa geçmişe ekle
        if (Auth::check()) {
            Pasts::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'product_id' => $data->id,
                ],
                [
                    'updated_at' => now(),
                ]
            );
        }

        $relatedProduct = ProductRelatedProduct::where('product_id', $data->id)->get();

        $commentProduct = Productcoms::orderBy('id','desc')->where('product_id', $data->id)->where('status',1)->limit(3)->get();

        return view('product::frontend.product.detail', compact(
            'data',
            'cargo',
            'reviews',
            'totalReviews',
            'avgRating',
            'ratings',
            'commentProduct',
            'relatedProduct',
            'type'
        ));
    }

    public function product_detail_comment($slug)
    {
        $type = "comment";
        $slugParts = explode('-', $slug);
        $productToken = end($slugParts);

        $data = Products::where('product_token', $productToken)
            ->where('status', 1)
            ->firstOrFail();


        // ✅ Yorumları çek
        $reviews = \App\Models\Productcoms::where('product_token', $productToken)
            ->where('status', '1')
            ->get();

        $totalReviews = $reviews->count();
        $avgRating = $reviews->avg('point') ?? 0;

        // ✅ Yıldız dağılımı
        $ratings = [
            5 => $reviews->where('point', 5)->count(),
            4 => $reviews->where('point', 4)->count(),
            3 => $reviews->where('point', 3)->count(),
            2 => $reviews->where('point', 2)->count(),
            1 => $reviews->where('point', 1)->count(),
        ];

        $dataComment = Productcoms::with(['items'])->where('product_id', $data->id)->where('status',1)->orderBy('id','desc')->paginate(10);

        return view('product::frontend.product.detail', compact(
            'data',
            'reviews',
            'totalReviews',
            'avgRating',
            'ratings',
            'type',
            'dataComment'
        ));

    }
    public function product_detail_ask($slug)
    {
        $type = "ask";
        $slugParts = explode('-', $slug);
        $productToken = end($slugParts);

        $data = Products::where('product_token', $productToken)
            ->where('status', 1)
            ->firstOrFail();



        // ✅ Yorumları çek
        $reviews = \App\Models\Productcoms::where('product_token', $productToken)
            ->where('status', '1')
            ->get();

        $totalReviews = $reviews->count();
        $avgRating = $reviews->avg('point') ?? 0;

        // ✅ Yıldız dağılımı
        $ratings = [
            5 => $reviews->where('point', 5)->count(),
            4 => $reviews->where('point', 4)->count(),
            3 => $reviews->where('point', 3)->count(),
            2 => $reviews->where('point', 2)->count(),
            1 => $reviews->where('point', 1)->count(),
        ];


        $dataAsk = Askques::where('product_id', $data->id)->where('status',1)->orderBy('id','desc')->paginate(10);

        return view('product::frontend.product.detail', compact(
            'data',
            'reviews',
            'totalReviews',
            'avgRating',
            'ratings',

            'type',
            'dataAsk'
        ));

        return view('product::frontend.product.detail', compact('find','data','type'));
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
