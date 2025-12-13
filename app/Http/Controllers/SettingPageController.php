<?php

namespace App\Http\Controllers;

use App\Models\SettingPage;
use Illuminate\Http\Request;

class SettingPageController extends Controller
{
    public function index()
    {
        $setting = SettingPage::first();
        $title = 'Setting Page';

        return view('settingpage.index', compact('setting', 'title'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_sppg' => 'nullable|string',
            'yayasan' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kabupaten_kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'nama_sppi' => 'nullable|string',
            'ahli_gizi' => 'nullable|string',
            'akuntan_sppg' => 'nullable|string',
            'asisten_lapangan' => 'nullable|string',
        ]);

        SettingPage::updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'Setting berhasil disimpan');
    }
}
