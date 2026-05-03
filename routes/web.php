<?php
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



/* =============================================================== */
Auth::routes();
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login.submit');
    Route::get('/auth/{provider}/redirect', [LoginController::class, 'redirectToProvider'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');
});


//System Annons
Route::get('/system',[ApiController::class, 'system_index'])->name('system_index');


/* FRONTEND START */
require __DIR__.'/frontend.php';

/* FRONTEND FINISH */


/* BACKEND START */
require __DIR__.'/backend.php';
/* BACKEND FINISH */

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');
