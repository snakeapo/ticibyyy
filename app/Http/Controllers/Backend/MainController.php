<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Carbon\Carbon;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //Panel home page
    public function panel_home()
    {
        $start_date = Carbon::now()->subDays(30);
        $end_date = Carbon::now();

        $total_amounts = Orders::whereBetween('created_at', [$start_date, $end_date])
                              ->selectRaw('date(created_at) as date, sum(total) as total_amount')
                              ->groupBy('date')
                              ->orderBy('date')
                              ->get();
        $total_orders = Orders::whereBetween('created_at', [$start_date, $end_date])
                              ->selectRaw('date(created_at) as date, count(*) as total')
                              ->groupBy('date')
                              ->orderBy('date')
                              ->get();
        $toplam_tutar = Orders::whereBetween('created_at', [$start_date, $end_date])
        ->sum('total');
        $toplam_siparis = Orders::whereBetween('created_at', [$start_date, $end_date])
        ->count();
        return view('setting::backend.main.index',compact('total_amounts','toplam_tutar','total_orders','toplam_siparis'));
    }
}
