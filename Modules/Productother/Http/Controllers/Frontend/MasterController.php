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
    public function ask_question_post(AskQuestionPostRequest $request, $product_token)
    {
        $formData = $request->validated();
        $product = Products::where('product_token', $product_token)->firstOrFail();
        $formData['product_id'] = $product->id;
        $formData['product_token'] = $product_token;
        $formData['user_id'] = Auth::user()->id;
        $formData['status'] = '0';
        Askques::create($formData);
        return back()->with('success', 'Sorunuz İletildi!');
    }

    // Favories insert
    public function product_favories($urun_no)
    {
        if (Auth::check()) {
            $c = Products::where('product_token', $urun_no)->count();
            if ($c != 0) {
                $control = Favories::where('product_token', $urun_no)->where('user_id', Auth::user()->id)->count();
                if ($control == 0) {
                    $product = Products::where('product_token', $urun_no)->firstOrFail();
                    Favories::create(['product_id' => $product->id, 'product_token' => $urun_no, 'user_id' => Auth::user()->id]);
                    return back()->with('success', 'Favorilere Eklendi.!');
                }

                Favories::where('product_token', $urun_no)->where('user_id', Auth::user()->id)->delete();
                return back()->with('success', 'Favorilerden Kaldırıldı.!');
            }

            abort(404);
        }

        return back()->with('error', 'Lütfen Giriş Yapın.!');
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
