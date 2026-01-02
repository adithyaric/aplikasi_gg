<?php

namespace App\Http\Controllers;

use App\Models\SettingPage;
use Illuminate\Http\Request;

class SettingPageController extends Controller
{
    public function index()
    {
        $settings = SettingPage::all();
        $title = 'Setting Pages';

        return view('settingpage.index', compact('settings', 'title'));
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
            'active' => 'nullable|boolean',
        ]);

        SettingPage::create($data);

        return back()->with('success', 'Setting berhasil ditambahkan');
    }

    public function update(Request $request, SettingPage $settingpage)
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
            'active' => 'nullable|boolean',
        ]);

        $settingpage->update($data);

        return back()->with('success', 'Setting berhasil diperbarui');
    }

    public function destroy(SettingPage $settingpage)
    {
        if ($settingpage->users()->count() > 0) {
            return back()->with('warning', 'Setting tidak dapat dihapus karena masih digunakan oleh user');
        }

        $settingpage->delete();

        return back()->with('success', 'Setting berhasil dihapus');
    }
}
