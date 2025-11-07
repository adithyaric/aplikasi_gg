<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard');
    }

    public function titikDistribusi(Request $request)
    {
        $schools = Sekolah::get();
        return view('titik-distribusi', ['schools' => $schools]);
    }

    // public function welcome()
    // {
    //     return view('homepage');
    // }
}
