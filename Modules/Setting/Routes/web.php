<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\Backend\SystemController as SettingBackendController;

Route::prefix('spanel')->middleware(['auth', 'admin'])->controller(SettingBackendController::class)->group(function () {
    Route::get('/web-setting', 'web_setting')->name('web_setting');
    Route::get('/theme-setting', 'theme_setting')->name('theme_setting');
    Route::post('/general-update/{id}', 'general_update')->name('general_update');
    Route::post('/social-update/{id}', 'social_update')->name('social_update');
    Route::post('/image-update/{id}', 'image_update')->name('image_update');
    Route::post('/contact-update/{id}', 'contact_update')->name('contact_update');
    Route::post('/module-update/{id}', 'module_update')->name('module_update');
    Route::get('/bank-setting', 'bank_setting')->name('bank_setting');
    Route::post('/bank-setting-create', 'bank_setting_create')->name('bank_setting_create');
    Route::post('/bank-setting-update/{id}', 'bank_setting_update')->name('bank_setting_update');
    Route::get('/bank-setting-delete/{id}', 'bank_setting_delete')->name('bank_setting_delete');
    Route::get('/cargo-setting', 'cargo_setting')->name('cargo_setting');
    Route::post('/cargo-setting-create', 'cargo_setting_create')->name('cargo_setting_create');
    Route::post('/cargo-setting-update/{id}', 'cargo_setting_update')->name('cargo_setting_update');
    Route::get('/cargo-setting-delete/{id}', 'cargo_setting_delete')->name('cargo_setting_delete');
    Route::get('/pos-setting', 'pos_setting')->name('pos_setting');
    Route::post('/pos-setting-update/{id}', 'pos_setting_update')->name('pos_setting_update');
    Route::get('/language-setting', 'language_setting')->name('language_setting');
    Route::post('/language-setting-create', 'language_setting_create')->name('language_setting_create');
    Route::post('/language-setting-update/{id}', 'language_setting_update')->name('language_setting_update');
    Route::get('/language-setting-delete/{id}', 'language_setting_delete')->name('language_setting_delete');
    Route::get('/language-setting-translate/{id}', 'language_setting_translate')->name('language_setting_translate');
    Route::post('/language-setting-translate-update/{id}', 'language_setting_translation_update')->name('language_setting_translation_update');
    Route::post('/language-setting-translate-create/{id}', 'language_setting_translation_create')->name('language_setting_translation_create');
    Route::get('/info-setting', 'info_setting')->name('info_setting');
    Route::get('/auth-info-card-setting', 'auth_info_card_setting')->name('auth_info_card_setting');
    Route::post('/auth-info-card-setting-create', 'auth_info_card_setting_create')->name('auth_info_card_setting_create');
    Route::post('/auth-info-card-setting-update/{id}', 'auth_info_card_setting_update')->name('auth_info_card_setting_update');
    Route::get('/auth-info-card-setting-delete/{id}', 'auth_info_card_setting_delete')->name('auth_info_card_setting_delete');
    Route::post('/info-setting-create', 'info_setting_create')->name('info_setting_create');
    Route::post('/info-setting-update/{id}', 'info_setting_update')->name('info_setting_update');
    Route::get('/info-setting-delete/{id}', 'info_setting_delete')->name('info_setting_delete');
});
