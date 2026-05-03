<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Favories extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_token',
    ];

    static function isSave($urun_no)
    {
        $c = Favories::where('product_token',$urun_no)->where('user_id',Auth::id())->count();
        if($c !=0){ return true;} else { return false;}
    }


    public function getProduct()
    {
        return $this->hasOne('App\Models\Products','id','product_id');
    }
}
