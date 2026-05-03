<?php

use App\Http\Controllers\Backend\MainController;
use Illuminate\Support\Facades\Route;

Route::prefix('spanel')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/control-panel', [MainController::class, 'panel_home'])->name('panel_home');
});

