<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\Infos;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //Home
    public function home_index()
    {
        $info = Infos::get();
        $brand = Brands::inRandomOrder()->limit(5)->get();
        return view('page::frontend.main.index',compact('info','brand'));
    }
}
