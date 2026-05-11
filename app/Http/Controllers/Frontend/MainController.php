<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Infos;
use App\Models\Products;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //Home
    public function home_index()
    {
        $info = Infos::get();
        $brand = Brands::inRandomOrder()->limit(5)->get();
        $trendProduct = Products::inRandomOrder()->where('best_selling',1)->where('status',1)->limit(12)->get();
        $ourProduct = Products::inRandomOrder()->where('our_choice',1)->where('status',1)->limit(12)->get();
        return view('page::frontend.main.index',compact(
            'info',
            'brand',
            'trendProduct',
            'ourProduct',
        ));
    }
}
