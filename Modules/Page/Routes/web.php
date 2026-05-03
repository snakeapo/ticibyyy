<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\Backend\SystemController as PageBackendController;
use Modules\Page\Http\Controllers\Frontend\MasterController as PageFrontendController;

Route::controller(PageFrontendController::class)->group(function () {
    Route::get('/sayfa/{page_slug}', 'page_detail')->name('page_detail');
    Route::get('/iletisim', 'contact_page')->name('contact_page');
    Route::post('/contact-post', 'contact_post')->name('contact_post');
});

Route::prefix('spanel')->middleware(['auth', 'admin'])->controller(PageBackendController::class)->group(function () {
    Route::get('/message-list', 'message_list')->name('message_list');
    Route::get('/message-read/{id}', 'message_read')->name('message_read');
    Route::get('/message-delete/{id}', 'message_delete')->name('message_delete');
    Route::get('/page-list', 'page_list')->name('page_list');
    Route::get('/page-insert', 'page_insert')->name('page_insert');
    Route::post('/page-create', 'page_create')->name('page_create');
    Route::get('/page-edit/{id}', 'page_edit')->name('page_edit');
    Route::post('/page-update/{id}', 'page_update')->name('page_update');
    Route::get('/page-delete/{id}', 'page_delete')->name('page_delete');
    Route::get('/slider-list', 'slider_list')->name('slider_list');
    Route::post('/slider-create', 'slider_create')->name('slider_create');
    Route::post('/slider-update/{id}', 'slider_update')->name('slider_update');
    Route::get('/slider-delete/{id}', 'slider_delete')->name('slider_delete');
    Route::get('/annons-list', 'annons_list')->name('annons_list');
    Route::post('/annons-create', 'annons_create')->name('annons_create');
    Route::post('/annons-update/{id}', 'annons_update')->name('annons_update');
    Route::get('/annons-delete/{id}', 'annons_delete')->name('annons_delete');
    Route::get('/customer-comment-list', 'customer_comment_list')->name('customer_comment_list');
    Route::post('/customer-comment-create', 'customer_comment_create')->name('customer_comment_create');
    Route::post('/customer-comment-update/{id}', 'customer_comment_update')->name('customer_comment_update');
    Route::get('/customer-comment-delete/{id}', 'customer_comment_delete')->name('customer_comment_delete');
});
