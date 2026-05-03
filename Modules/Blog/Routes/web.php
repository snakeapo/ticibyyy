<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\Backend\SystemController as BlogBackendController;
use Modules\Blog\Http\Controllers\Frontend\MasterController as BlogFrontendController;

Route::controller(BlogFrontendController::class)->group(function () {
    Route::get('/yazilar', 'blog_page')->name('blog_page');
    Route::get('/yazi/detay/{blog_slug}', 'blog_detail')->name('blog_detail');
    Route::get('/yazi/kategori/{category_slug}', 'blog_category_detail')->name('blog_category_detail');
});

Route::prefix('spanel')->middleware(['auth', 'admin'])->controller(BlogBackendController::class)->group(function () {
    Route::get('/blog-list', 'blog_list')->name('blog_list');
    Route::get('/blog-insert', 'blog_insert')->name('blog_insert');
    Route::post('/blog-create', 'blog_create')->name('blog_create');
    Route::get('/blog-edit/{id}', 'blog_edit')->name('blog_edit');
    Route::post('/blog-update/{id}', 'blog_update')->name('blog_update');
    Route::get('/blog-delete/{id}', 'blog_delete')->name('blog_delete');
    Route::get('/blog-category-list', 'blog_category_list')->name('blog_category_list');
    Route::post('/blog-category-insert', 'blog_category_insert')->name('blog_category_insert');
    Route::post('/blog-category-update/{id}', 'blog_category_update')->name('blog_category_update');
    Route::get('/blog-category-delete/{id}', 'blog_category_delete')->name('blog_category_delete');
});
