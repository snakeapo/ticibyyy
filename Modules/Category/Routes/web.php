<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\Backend\SystemController as CategorySystemController;
use Modules\Category\Http\Controllers\Frontend\MasterController as CategoryMasterController;

Route::prefix('kategori')->controller(CategoryMasterController::class)->group(function () {
    Route::get('/', 'index')->name('kategori.index');
    Route::get('/{top}/{sub}/{child}', 'sub_category_detail')->name('sub_category_detail');
    Route::get('/{top}/{sub}', 'sub_parent_category_detail')->name('sub_parent_category_detail');
    Route::get('/{top}', 'top_category_detail')->name('top_category_detail');

});

Route::prefix('spanel')->middleware(['auth', 'admin'])->controller(CategorySystemController::class)->group(function () {
    Route::get('/category-list', 'category_list')->name('category_list');
    Route::post('/category-create', 'category_create')->name('category_create');
    Route::post('/category-update/{id}', 'category_update')->name('category_update');
    Route::get('/category-edit/{id}', 'category_edit')->name('category_edit');
    Route::delete('/category-delete/{id}', 'category_delete')->name('category_delete');

    Route::get('/subcategory-list', 'subcategory_list')->name('subcategory_list');
    Route::post('/subcategory-create', 'subcategory_create')->name('subcategory_create');
    Route::post('/subcategory-update/{id}', 'subcategory_update')->name('subcategory_update');
    Route::get('/subcategory-edit/{id}', 'subcategory_edit')->name('subcategory_edit');
    Route::delete('/subcategory-delete/{id}', 'subcategory_delete')->name('subcategory_delete');
});
