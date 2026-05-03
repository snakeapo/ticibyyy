<?php

use Illuminate\Support\Facades\Route;
use Modules\Auction\Http\Controllers\Backend\SystemController as AuctionBackendController;
use Modules\Auction\Http\Controllers\Frontend\MasterController as AuctionFrontendController;

Route::controller(AuctionFrontendController::class)->group(function () {
    Route::get('/mezatlar', 'index')->name('auction_live_index');
    Route::get('/mezat/{auction}', 'show')->name('auction_live_show');
    Route::get('/mezat/{auction}/state', 'state')->name('auction_live_state');

    Route::middleware('auth')->group(function () {
        Route::post('/mezat/item/{item}/bid', 'bid')->name('auction_live_bid');
        Route::post('/mezat/item/{item}/buy-now', 'buyNow')->name('auction_live_buy_now');
        Route::get('/mezat-siparislerim', 'myOrders')->name('auction_live_my_orders');
        Route::get('/mezat-siparislerim/{order}', 'orderDetail')->name('auction_live_order_detail');
    });
});

Route::prefix('spanel')->middleware(['auth', 'admin'])->controller(AuctionBackendController::class)->group(function () {
    Route::get('/auctions', 'index')->name('auction_admin_index');
    Route::get('/auction-orders', 'orders')->name('auction_admin_orders');
    Route::get('/auction-orders/{order}', 'showOrder')->name('auction_admin_order_show');
    Route::post('/auctions', 'store')->name('auction_admin_store');
    Route::delete('/auctions/{auction}', 'destroy')->name('auction_admin_destroy');
    Route::post('/auctions/{auction}/start', 'start')->name('auction_admin_start');
    Route::post('/auctions/{auction}/next', 'next')->name('auction_admin_next');
    Route::post('/auctions/{auction}/items', 'addItem')->name('auction_admin_add_item');
    Route::delete('/auctions/{auction}/items/{item}', 'removeItem')->name('auction_admin_remove_item');
    Route::get('/auctions/{auction}/state', 'state')->name('auction_admin_state');
});
