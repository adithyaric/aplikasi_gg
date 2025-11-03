<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\BahanOperasionalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GiziController;
use App\Http\Controllers\KategoriSkmController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\PaketMenuController;
use App\Http\Controllers\PaketSurveyController;
use App\Http\Controllers\RespondenController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('welcome'));
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'login'])->name('authenticate');
    Route::get('/welcome', [DashboardController::class, 'welcome'])->name('welcome');

    Route::prefix('survey')->name('survey.')->group(function () {
        Route::get('/', [SurveyController::class, 'index'])->name('index');
        Route::get('/paket/{kategori_id}', [SurveyController::class, 'getPaket']);
        Route::get('/kuesioner/{paket_id}', [SurveyController::class, 'getKuesioner']);
        Route::post('/submit', [SurveyController::class, 'submit'])->name('submit');
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('bahanbaku', BahanBakuController::class);
    Route::resource('bahanoperasional', BahanOperasionalController::class);
    Route::resource('gizi', GiziController::class);
    Route::resource('paketmenu', PaketMenuController::class);

    Route::resource('categories', CategoryController::class);
    Route::resource('surats', SuratController::class);
    Route::get('/surats/{id}/cetak', [SuratController::class, 'cetak'])->name('surats.cetak');
    Route::prefix('skm')->name('skm.')->group(function () {
        Route::resource('kategori', KategoriSkmController::class);
        Route::resource('paket', PaketSurveyController::class);
        Route::resource('kuesioner', KuesionerController::class);
    });

});


