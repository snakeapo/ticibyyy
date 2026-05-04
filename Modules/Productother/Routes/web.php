<?php

use Illuminate\Support\Facades\Route;
use Modules\Productother\Http\Controllers\Backend\SystemController as ProductOtherBackendController;
use Modules\Productother\Http\Controllers\Frontend\MasterController as ProductOtherFrontendController;

Route::controller(ProductOtherFrontendController::class)->group(function () {
    Route::get('/favorilere-kaydet/{urun_no}', 'product_favories')->name('product_favories');
    Route::get('/compare', 'compare_index')->name('compare_index');
    Route::get('/compare-add/{urun_no}', 'compare_post')->name('compare_post');
    Route::get('/compare-delete/{id}', 'compare_delete')->name('compare_delete');
    Route::post('/soru-sor/{product_token}', 'ask_question_post')->name('ask_question_post');
});

Route::prefix('spanel')->middleware(['auth', 'admin'])->controller(ProductOtherBackendController::class)->group(function () {
    Route::get('/product-image/{id}', 'product_image')->name('product_image');
    Route::post('/product-image-create/{token}', 'product_image_create')->name('product_image_create');
    Route::post('/product-image-update/{id}', 'product_image_update')->name('product_image_update');
    Route::get('/product-image-delete/{id}', 'product_image_delete')->name('product_image_delete');
    Route::get('/product-variant/{id}', 'product_variant')->name('product_variant');
    Route::get('/variant-stock-alerts', 'variant_stock_alerts')->name('variant_stock_alerts');
    Route::post('/product-variant-create/{token}', 'product_variant_create')->name('product_variant_create');
    Route::post('/product-variant-update/{id}', 'product_variant_update')->name('product_variant_update');
    Route::get('/product-variant-delete/{id}', 'product_variant_delete')->name('product_variant_delete');
    Route::get('/brand-list', 'brand_list')->name('brand_list');
    Route::post('/brand-create', 'brand_create')->name('brand_create');
    Route::get('/brand-edit/{id}', 'brand_edit')->name('brand_edit');
    Route::post('/brand-update/{id}', 'brand_update')->name('brand_update');
    Route::delete('/brand-delete/{id}', 'brand_delete')->name('brand_delete');
    Route::get('/coupon-list', 'coupon_list')->name('coupon_list');
    Route::get('/coupon-create', 'coupon_create_page')->name('coupon_create_page');
    Route::post('/coupon-create', 'coupon_create')->name('coupon_create');
    Route::get('/coupon-edit/{id}', 'coupon_edit_page')->name('coupon_edit_page');
    Route::post('/coupon-update/{id}', 'coupon_update')->name('coupon_update');
    Route::get('/coupon-delete/{id}', 'coupon_delete')->name('coupon_delete');
    Route::get('/comment-list', 'comment_list')->name('comment_list');
    Route::post('/comment-answer/{id}', 'comment_update')->name('comment_update');
    Route::get('/comment-okay/{id}', 'comment_okay')->name('comment_okay');
    Route::get('/comment-reject/{id}', 'comment_reject')->name('comment_reject');
    Route::get('/comment-delete/{id}', 'comment_delete')->name('comment_delete');
    Route::get('/question-list', 'question_list')->name('question_list');
    Route::post('/question-answer/{id}', 'question_answer')->name('question_answer');
    Route::get('/question-delete/{id}', 'question_delete')->name('question_delete');
});
