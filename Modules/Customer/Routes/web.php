<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\Backend\SystemController as CustomerBackendController;
use Modules\Customer\Http\Controllers\Frontend\MasterController as CustomerFrontendController;

Route::prefix('hesap')->middleware('auth')->controller(CustomerFrontendController::class)->group(function () {
    Route::get('/kullanici/paneli', 'user_panel')->name('user_panel');
    Route::post('/user-post', 'user_post')->name('user_post');
    Route::get('/sifre-degistir', 'password_change')->name('password_change');
    Route::post('/password-update', 'password_change_user')->name('password_change_user');

    Route::get('/adreslerim','my_address')->name('my_address');
    Route::post('/new-address','new_address')->name('new_address');
    Route::post('/update-address/{id}','update_address')->name('update_address');
    Route::delete('/delete-address/{id}','delete_address')->name('delete_address');

    Route::get('/duyuru-tercihlerim','notice_setting')->name('notice_setting');
    Route::post('/notice-setting','notice_setting_update')->name('notice_setting_update');


    Route::get('/siparislerim', 'my_order')->name('my_order');
    Route::get('/siparis-detay/{order_token}', 'order_detail')->name('user_order_detail');

    Route::get('/degerlendirmelerim','my_comment')->name('my_comment');
    Route::post('/yorum-yap/{id}', 'comment_insert')->name('comment_insert');

    Route::get('/indirim-kuponlarim','my_coupon')->name('my_coupon');
    Route::get('/favoriler', 'favories_page')->name('favories_page');
});

Route::prefix('spanel')->middleware(['auth', 'admin'])->controller(CustomerBackendController::class)->group(function () {
    Route::get('/user-list', 'user_list')->name('user_list');
    Route::get('/user-insert', 'user_insert')->name('user_insert');
    Route::post('/user-create', 'user_create')->name('user_create');
    Route::get('/user-edit/{id}', 'user_edit')->name('user_edit');
    Route::post('/user-update/{id}', 'user_update')->name('user_update');
    Route::post('/change-password/{id}', 'change_password')->name('change_password');
    Route::get('/user-delete/{id}', 'user_delete')->name('user_delete');
    Route::get('/admin-list', 'admin_list')->name('admin_list');
    Route::get('/stock-notify', 'stock_notify')->name('stock_notify');
    Route::get('/stock-notify-delete/{id}', 'stock_notify_delete')->name('stock_notify_delete');
    Route::get('/withdraw', 'withdraw')->name('withdraw');
    Route::get('/withdraw-okay/{id}', 'withdraw_okay')->name('withdraw_okay');
    Route::get('/withdraw-reject/{id}', 'withdraw_reject')->name('withdraw_reject');
    Route::get('/withdraw-delete/{id}', 'withdraw_delete')->name('withdraw_delete');
});
