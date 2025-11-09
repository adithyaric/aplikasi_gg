<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard');
    }

    public function titikDistribusi(Request $request)
    {
        $schools = Sekolah::get([
            'id',
            'nama',
            'nama_pic',
            'nomor',
            'jarak',
            'alamat',
            'long',
            'lat',
            'porsi_8k',
            'porsi_10k',
        ]);
        $suppliers = Supplier::get([
            'id',
            'nama',
            'no_hp',
            'bank_no_rek',
            'bank_nama',
            'alamat',
            'long',
            'lat',
            'products',
        ]);
        return view('titik-distribusi', [
            'schools' => $schools,
            'suppliers' => $suppliers
        ]);
    }

    // public function welcome()
    // {
    //     return view('homepage');
    // }
}
