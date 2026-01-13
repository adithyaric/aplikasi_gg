<?php

// app/Http/Controllers/ImportController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BahanBakuImport;
use App\Imports\BahanOperasionalImport;
use App\Imports\GiziImport;
use App\Imports\SekolahImport;
use App\Imports\SupplierImport;
use App\Imports\KaryawanImport;
use App\Imports\KategoriKaryawanImport;
use App\Imports\RekeningKoranVAImport;

class ImportController extends Controller
{
    public function importBahanBaku(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new BahanBakuImport, $request->file('file'));
        return back()->with('success', 'Bahan Baku imported successfully.');
    }

    public function importBahanOperasional(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new BahanOperasionalImport, $request->file('file'));
        return back()->with('success', 'Bahan Operasional imported successfully.');
    }

    public function importGizi(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new GiziImport, $request->file('file'));
        return back()->with('success', 'Data Gizi imported successfully.');
    }

    public function importSekolah(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new SekolahImport, $request->file('file'));
        return back()->with('success', 'Sekolah imported successfully.');
    }

    public function importSupplier(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new SupplierImport, $request->file('file'));
        return back()->with('success', 'Supplier imported successfully.');
    }

    public function importKategoriKaryawan(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new KategoriKaryawanImport, $request->file('file'));
        return back()->with('success', 'Kategori karyawan imported successfully.');
    }

    public function importKaryawan(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new KaryawanImport, $request->file('file'));
        return back()->with('success', 'Karyawan imported successfully.');
    }

    public function importRekeningKoranVA(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);
        Excel::import(new RekeningKoranVAImport, $request->file('file'));
        return back()->with('success', 'RekeningKoranVA imported successfully.');
    }
}