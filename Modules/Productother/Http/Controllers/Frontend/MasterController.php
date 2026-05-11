<?php

namespace Modules\Productother\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Askques;
use App\Models\Compares;
use App\Models\Favories;
use App\Models\Products;
use Illuminate\Http\Request;
use Modules\Productother\Http\Requests\Frontend\AskQuestionPostRequest;
use Illuminate\Support\Facades\Auth;

class MasterController extends Controller
{
    // Soru Sor
    public function ask_question_post(AskQuestionPostRequest $request, $id)
    {
        if(Auth::check()){
            $formData = $request->validated();
            $product = Products::where('id', $id)->firstOrFail();
            $formData['product_id'] = $id;
            $formData['product_token'] = $product->product_token;
            $formData['user_id'] = Auth::user()->id;
            $formData['status'] = '0';
            Askques::create($formData);
            return back()->with('success', 'Sorunuz İletildi!');
        }else{
            return back()->with('error','Lütfen önce giriş yapın.');
        }

    }

    // Favories insert
    public function product_favories(Request $request, $urun_no)
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Lütfen Giriş Yapın.!',
                ], 401);
            }

            return back()->with('error', 'Lütfen Giriş Yapın.!');
        }

        $product = Products::where('product_token', $urun_no)->firstOrFail();
        $favorite = Favories::where('product_token', $urun_no)->where('user_id', Auth::id())->first();

        if ($favorite) {
            $favorite->delete();
            $saved = false;
            $message = 'Favorilerden Kaldırıldı.!';
        } else {
            Favories::create([
                'product_id' => $product->id,
                'product_token' => $urun_no,
                'user_id' => Auth::id(),
            ]);
            $saved = true;
            $message = 'Favorilere Eklendi.!';
        }

        if ($request->expectsJson()) {
            return response()->json([
                'saved' => $saved,
                'product_token' => $urun_no,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    // Compare
    public function compare_post($urun_no)
    {
        $product = Products::where('product_token', $urun_no)->firstOrFail();
        Compares::insert([
            'product_id' => $product->id,
            'product_token' => $urun_no,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        ]);
        return redirect()->route('compare_index')->with('success', 'Ürün Karşılaştırmalara Eklendi');
    }

    // Compare Index
    public function compare_index()
    {
        $data = Compares::where('ip_address', $_SERVER['REMOTE_ADDR'])->get();
        return view('productother::frontend.product.compare', compact('data'));
    }

    // Compare Delete
    public function compare_delete($id)
    {
        Compares::where('id', $id)->delete();
        return back()->with('success', 'Karşılaştırmalardan Kaldırıldı');
    }

    // Product Favories Delete
    public function favories_delete($id)
    {
        $favori = Favories::findOrFail($id);
        $favori->delete();
        return back()->with('success', 'Ürün Favorilerinizden Kaldırıldı!');
    }
}
