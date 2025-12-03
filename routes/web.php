<?php

use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\BahanOperasionalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GiziController;
use App\Http\Controllers\KategoriSkmController;
use App\Http\Controllers\KuesionerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaketMenuController;
use App\Http\Controllers\PaketSurveyController;
use App\Http\Controllers\RekeningKoranVaController;
use App\Http\Controllers\RekeningRekapBKUController;
use App\Http\Controllers\RencanaMenuController;
use App\Http\Controllers\RespondenController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
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
    return redirect(route('dashboard'));
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'login'])->name('authenticate');
    // Route::get('/welcome', [DashboardController::class, 'welcome'])->name('welcome');

    // Route::prefix('survey')->name('survey.')->group(function () {
    //     Route::get('/', [SurveyController::class, 'index'])->name('index');
    //     Route::get('/paket/{kategori_id}', [SurveyController::class, 'getPaket']);
    //     Route::get('/kuesioner/{paket_id}', [SurveyController::class, 'getKuesioner']);
    //     Route::post('/submit', [SurveyController::class, 'submit'])->name('submit');
    // });
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/titik-distribusi', [DashboardController::class, 'titikDistribusi'])->name('titik-distribusi');
    Route::get('/rekonsiliasi', [DashboardController::class, 'rekonsiliasi'])->name('rekonsiliasi');

    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);

    //master data
    Route::resource('bahanbaku', BahanBakuController::class);
    Route::resource('bahanoperasional', BahanOperasionalController::class);
    Route::resource('gizi', GiziController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('paketmenu', PaketMenuController::class);
    Route::resource('rencanamenu', RencanaMenuController::class);
    Route::resource('sekolah', SekolahController::class);
    Route::resource('supplier', SupplierController::class);

    Route::resource('orders', OrderController::class);
    Route::get('/orders-add-menu-items', [OrderController::class, 'addMenuItems'])->name('orders.addMenuItems');
    Route::put('/orders/{order}/topost', [OrderController::class, 'UpdateToPost'])->name('orders.updateToPost');

    Route::get('/penerimaan', [OrderController::class, 'penerimaanIndex'])->name('penerimaan.index');
    Route::get('/penerimaan/{order}/edit', [OrderController::class, 'editPenerimaan'])->name('penerimaan.edit');
    Route::put('/penerimaan/{order}', [OrderController::class, 'updatePenerimaan'])->name('penerimaan.update');

    Route::get('/pembayaran', [OrderController::class, 'pembayaranIndex'])->name('pembayaran.index');
    Route::get('/pembayaran/{order}/edit', [OrderController::class, 'editPembayaran'])->name('pembayaran.edit');
    Route::put('/pembayaran/{order}', [OrderController::class, 'updatePembayaran'])->name('pembayaran.update');

    Route::get('/stok-kartu', [StokController::class, 'kartu'])->name('stok.kartu');
    Route::get('/stok/kartu/data', [StokController::class, 'getKartuData'])->name('stok.kartu.data');

    Route::resource('stok', StokController::class);
    Route::get('/stok/{bahanId}/{type}', [StokController::class, 'show'])->name('stok.show');

    Route::get('/stok-opname', [StokController::class, 'opname'])->name('stok.opname');
    Route::get('/stok-opname/data', [StokController::class, 'getOpnameData'])->name('stok.opname.data');
    Route::post('/stok-opname/save', [StokController::class, 'saveOpname'])->name('stok.opname.save');

    Route::resource('rekening-koran-va', RekeningKoranVaController::class);
    Route::resource('rekening-rekap-bku', RekeningRekapBKUController::class);

    Route::resource('anggaran', AnggaranController::class);
    // Route::resource('surats', SuratController::class);
    // Route::get('/surats/{id}/cetak', [SuratController::class, 'cetak'])->name('surats.cetak');
    // Route::prefix('skm')->name('skm.')->group(function () {
    //     Route::resource('kategori', KategoriSkmController::class);
    //     Route::resource('paket', PaketSurveyController::class);
    //     Route::resource('kuesioner', KuesionerController::class);
    // });
});


