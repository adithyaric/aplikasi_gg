<?php

use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\BahanOperasionalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GiziController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriKaryawanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaketMenuController;
use App\Http\Controllers\RekeningKoranVaController;
use App\Http\Controllers\RekeningRekapBKUController;
use App\Http\Controllers\RencanaMenuController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/authenticate', [AuthController::class, 'login'])->name('authenticate');
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

    Route::resource('karyawan', KaryawanController::class);
    Route::resource('kategori-karyawan', KategoriKaryawanController::class);
});
