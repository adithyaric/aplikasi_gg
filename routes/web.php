<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\BahanOperasionalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\GiziController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriKaryawanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaketMenuController;
use App\Http\Controllers\RekeningKoranVaController;
use App\Http\Controllers\RekeningRekapBKUController;
use App\Http\Controllers\RencanaMenuController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SettingPageController;
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

// Dashboard & Setting for all roles
Route::middleware(['auth', 'role:superadmin,admin,akuntan,ahligizi'])->group(function () {
    Route::resource('settingpage', SettingPageController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');
    Route::get('/titik-distribusi', [DashboardController::class, 'titikDistribusi'])->name('titik-distribusi');
    Route::get('/rekonsiliasi', [DashboardController::class, 'rekonsiliasi'])->name('rekonsiliasi');
});

// Routes for Bahan Baku, Bahan Operasional, Gizi, Menu, Paket Menu, Perencanaan Menu (Admin & Ahli Gizi only)
Route::middleware(['auth', 'role:superadmin,admin,ahligizi'])->group(function () {
    Route::resource('bahanbaku', BahanBakuController::class);
    Route::resource('bahanoperasional', BahanOperasionalController::class);
    Route::resource('gizi', GiziController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('paketmenu', PaketMenuController::class);
    Route::resource('rencanamenu', RencanaMenuController::class);

    // Import for gizi
    Route::post('/import-excel/gizi', [ImportController::class, 'importGizi'])->name('import.gizi');

    // Export for menu-related
    Route::get('export-excel/rencana-menu', [ExportController::class, 'exportRencanaMenu'])->name('export.rencana-menu');
});

// Routes for Akuntan (Admin + Akuntan) - excluding gizi/menu/paketmenu
Route::middleware(['auth', 'role:superadmin,admin,akuntan'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('sekolah', SekolahController::class);
    Route::resource('supplier', SupplierController::class);

    Route::resource('orders', OrderController::class);
    Route::get('/orders-add-menu-items', [OrderController::class, 'addMenuItems'])->name('orders.addMenuItems');
    Route::put('/orders/{order}/topost', [OrderController::class, 'UpdateToPost'])->name('orders.updateToPost');

    // Penerimaan, Penggunaan, Pembayaran
    Route::get('/penerimaan', [OrderController::class, 'penerimaanIndex'])->name('penerimaan.index');
    Route::get('/penerimaan/{order}/edit', [OrderController::class, 'editPenerimaan'])->name('penerimaan.edit');
    Route::put('/penerimaan/{order}', [OrderController::class, 'updatePenerimaan'])->name('penerimaan.update');

    Route::get('/penggunaan', [OrderController::class, 'penggunaanIndex'])->name('penggunaan.index');
    Route::get('/penggunaan/{order}/edit', [OrderController::class, 'editPenggunaan'])->name('penggunaan.edit');
    Route::put('/penggunaan/{order}', [OrderController::class, 'updatePenggunaan'])->name('penggunaan.update');

    Route::get('/pembayaran', [OrderController::class, 'pembayaranIndex'])->name('pembayaran.index');
    Route::get('/pembayaran/{order}/edit', [OrderController::class, 'editPembayaran'])->name('pembayaran.edit');
    Route::put('/pembayaran/{order}', [OrderController::class, 'updatePembayaran'])->name('pembayaran.update');

    // Stok
    Route::get('/stok-kartu', [StokController::class, 'kartu'])->name('stok.kartu');
    Route::get('/stok/kartu/data', [StokController::class, 'getKartuData'])->name('stok.kartu.data');

    Route::resource('stok', StokController::class);
    Route::get('/stok/{bahanId}/{type}', [StokController::class, 'show'])->name('stok.show');

    Route::get('/stok-opname', [StokController::class, 'opname'])->name('stok.opname');
    Route::get('/stok-opname/data', [StokController::class, 'getOpnameData'])->name('stok.opname.data');
    Route::post('/stok-opname/save', [StokController::class, 'saveOpname'])->name('stok.opname.save');

    // Rekening & Anggaran
    Route::resource('rekening-koran-va', RekeningKoranVaController::class);
    Route::resource('rekening-rekap-bku', RekeningRekapBKUController::class);

    Route::resource('anggaran', AnggaranController::class);

    // Karyawan, Absen & Gaji
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('kategori-karyawan', KategoriKaryawanController::class);

    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::post('/absensi/bulk-confirm/{tanggal}', [AbsensiController::class, 'bulkConfirm'])->name('absensi.bulk-confirm');
    Route::get('/absensi/{tanggal}', [AbsensiController::class, 'show'])->name('absensi.show');

    Route::get('/gaji', [GajiController::class, 'index'])->name('gaji.index');
    Route::get('/gaji/create', [GajiController::class, 'create'])->name('gaji.create');
    Route::post('/gaji', [GajiController::class, 'store'])->name('gaji.store');
    Route::get('/gaji/{gaji}', [GajiController::class, 'show'])->name('gaji.show');

    Route::get('/gaji/period-detail/{tanggal_mulai}/{tanggal_akhir}', [GajiController::class, 'periodDetail'])->name('gaji.period-detail');
    Route::post('/gaji/bulk-confirm/{tanggal_mulai}/{tanggal_akhir}', [GajiController::class, 'bulkConfirm'])->name('gaji.bulk-confirm');

    // Reports
    Route::prefix('report')->controller(ReportController::class)->group(function () {
        Route::get('rekap-porsi', 'rekapPorsi')->name('report.rekap-porsi');
        Route::get('rekap-penerimaan-dana', 'rekapPenerimaanDana')->name('report.rekap-penerimaan-dana');
        Route::get('bku', 'bku')->name('report.bku');
        Route::get('lpdb', 'lpdb')->name('report.lpdb');
        Route::get('lbbp', 'lbbp')->name('report.lbbp');
        Route::get('lbo', 'lbo')->name('report.lbo');
        Route::get('lbs', 'lbs')->name('report.lbs');
        Route::get('lra', 'lra')->name('report.lra');
    });

    // Import excel (non-gizi)
    Route::post('/import-excel/bahan-baku', [ImportController::class, 'importBahanBaku'])->name('import.bahan-baku');
    Route::post('/import-excel/bahan-operasional', [ImportController::class, 'importBahanOperasional'])->name('import.bahan-operasional');
    Route::post('/import-excel/gizi', [ImportController::class, 'importGizi'])->name('import.gizi');
    Route::post('/import-excel/sekolah', [ImportController::class, 'importSekolah'])->name('import.sekolah');
    Route::post('/import-excel/supplier', [ImportController::class, 'importSupplier'])->name('import.supplier');
    Route::post('/import-excel/kategori-karyawan', [ImportController::class, 'importKategoriKaryawan'])->name('import.kategori_karyawan');
    Route::post('/import-excel/karyawan', [ImportController::class, 'importKaryawan'])->name('import.karyawan');
    Route::post('/import-excel/rekening-koran-va', [ImportController::class, 'importRekeningKoranVA'])->name('import.rekening-koran-va');

    // Export excel (non-gizi)
    Route::get('export-excel/rekap-porsi', [ExportController::class, 'exportRekapPorsi'])->name('export.rekap-porsi');
    Route::get('export-excel/rekap-penerimaan-dana', [ExportController::class, 'exportRekapPenerimaanDana'])->name('export.rekap-penerimaan-dana');
    Route::get('export-excel/rekonsiliasi', [ExportController::class, 'exportRekonsiliasi'])->name('export.rekonsiliasi');
    Route::get('export-excel/sekolah', [ExportController::class, 'exportSekolah'])->name('export.sekolah');
    Route::get('export-excel/supplier', [ExportController::class, 'exportSupplier'])->name('export.supplier');
    Route::get('export-excel/relawan', [ExportController::class, 'exportRelawan'])->name('export.relawan');
    Route::get('export-excel/absensi/{tanggal}', [ExportController::class, 'exportAbsensi'])->name('export.absensi');
    Route::get('export-excel/gaji/{tanggal_mulai}/{tanggal_akhir}', [ExportController::class, 'exportGaji'])->name('export.gaji');
    Route::get('export-excel/stok', [ExportController::class, 'exportStok'])->name('export.stok');
    Route::get('export-excel/kartu-stok', [ExportController::class, 'exportKartuStok'])->name('export.kartu-stok');
    Route::get('export-excel/opname-stok', [ExportController::class, 'exportOpnameStok'])->name('export.opname-stok');
    Route::get('export-excel/purchase-order/{id}', [ExportController::class, 'exportPurchaseOrder'])->name('export.purchase-order');
    Route::get('export-excel/bku', [ExportController::class, 'exportBKU'])->name('export.bku');
    Route::get('export-excel/lpdb', [ExportController::class, 'exportLPDB'])->name('export.lpdb');
    Route::get('export-excel/lbbp', [ExportController::class, 'exportLBBP'])->name('export.lbbp');
    Route::get('export-excel/lbo', [ExportController::class, 'exportLBO'])->name('export.lbo');
    Route::get('export-excel/lbs', [ExportController::class, 'exportLBS'])->name('export.lbs');
    Route::get('export-excel/lra', [ExportController::class, 'exportLRA'])->name('export.lra');
    Route::get('export-excel/rencana-menu', [ExportController::class, 'exportRencanaMenu'])->name('export.rencana-menu');
    Route::get('export-excel/bast/{id}', [ExportController::class, 'exportBAST'])->name('export.bast');
    Route::get('export-excel/rekening-koran-va', [ExportController::class, 'exportRekeningKoranVA'])->name('export.rekening-koran-va');
});
