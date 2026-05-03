<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Backend\SystemController as ProductBackendController;
use Modules\Product\Http\Controllers\Frontend\MasterController as ProductFrontendController;

Route::controller(ProductFrontendController::class)->group(function () {
    Route::get('/urun/{slug}', 'product_detail')->name('product_detail');
    Route::get('/urun-yorumlari/{slug}', 'product_detail_comment')->name('product_detail_comment');
    Route::get('/urun-sorulari/{slug}', 'product_detail_ask')->name('product_detail_ask');
    Route::post('/stok-bildiri/{product_token}', 'stok_bildir')->name('stok_bildir');
    Route::get('/ara', 'product_search')->name('product_search');
    Route::get('/urun-filtrele', 'product_filter')->name('product_filter');
    Route::get('/markalar', 'all_brand')->name('all_brand');
    Route::get('/marka/{slug}', 'brand_detail')->name('brand_detail');
});

Route::prefix('spanel')->middleware(['auth', 'admin'])->controller(ProductBackendController::class)->group(function () {
    Route::get('/product-list', 'product_list')->name('product_list');
    Route::get('/product-insert', 'product_insert')->name('product_insert');
    Route::post('/product-create', 'product_create')->name('product_create');
    Route::post('/product-quick-create', 'product_quick_create')->name('product_quick_create');
    Route::post('/product-bulk-import', 'product_bulk_import')->name('product_bulk_import');
    Route::get('/product-import-template/{type}', 'product_import_template')->name('product_import_template');
    Route::get('/product-edit/{id}', 'product_edit')->name('product_edit');
    Route::post('/product-update/{id}', 'product_update')->name('product_update');
    Route::delete('/product-delete/{id}', 'product_delete')->name('product_delete');
    Route::get('/product-related/{id}', 'product_related')->name('product_related');
    Route::get('/collections', 'collections')->name('collections');
    Route::get('/get-sub-categories', 'getSubCategories')->name('getSubCategories');
});
