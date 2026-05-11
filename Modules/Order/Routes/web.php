<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\Backend\SystemController as OrderBackendController;
use Modules\Order\Http\Controllers\Frontend\MasterController as OrderFrontendController;

Route::controller(OrderFrontendController::class)->group(function () {
    Route::get('/sepet', 'shopping_cart')->name('shopping_cart')->middleware('auth');
    Route::post('/sepet-onay', 'cart_approval')->name('cart_approval')->middleware('auth');
    Route::post('/sepet-kupon-uygula', 'cart_apply_coupon')->name('cart_apply_coupon')->middleware('auth');
    Route::post('/sepet-kupon-kaldir', 'cart_remove_coupon')->name('cart_remove_coupon')->middleware('auth');
    Route::get('/sepet-arttir/{basket_token}', 'cart_increase')->name('cart_increase')->middleware('auth');
    Route::get('/sepet-azalt/{basket_token}', 'cart_decrease')->name('cart_decrease')->middleware('auth');
    Route::get('/urun-kaldir/{basket_token}', 'cart_delete_product')->name('cart_delete_product')->middleware('auth');
    Route::get('/siparis/onay/{order_token}', 'order_approval')->name('order_approval')->middleware('auth');
    Route::post('/siparis-post/{order_token}', 'order_post')->name('order_post')->middleware('auth');
    Route::match(['get', 'post'], '/paytr-odeme-basarili', 'odeme_basarili')->name('odeme_basarili');
    Route::get('/siparis-tamamlandi/{order_token}', 'order_complated')->name('order_complated')->middleware('auth');
    Route::get('/siparis-basarisiz/{order_token}', 'order_cancelled')->name('order_cancelled')->middleware('auth');
    Route::post('/cart-insert/{product_token}', 'cart_insert')->name('cart_insert')->middleware('auth');
    Route::get('/invoice/{order_token}', 'invoice')->name('invoice')->middleware(['auth', 'admin']);
});

Route::prefix('spanel')->middleware(['auth', 'admin'])->controller(OrderBackendController::class)->group(function () {
    Route::get('/order-list/{slug}', 'order_list')->name('order_list');
    Route::get('/live-basket', 'live_basket')->name('live_basket');
    Route::get('/order-detail/{id}', 'order_detail')->name('order_detail');
    Route::post('/order-status/{order_no}', 'order_status')->name('order_status');
    Route::get('/order-delete/{id}', 'order_delete')->name('order_delete');
});
