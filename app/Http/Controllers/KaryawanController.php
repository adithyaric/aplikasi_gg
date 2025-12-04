<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\KategoriKaryawan;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('kategori')->latest()->get();
        $title = 'Master Karyawan';
        $kategoris = KategoriKaryawan::all();
        return view('karyawan.index', compact('karyawans', 'title', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:255',
            'lahir_tempat' => 'nullable|string|max:255',
            'lahir_tanggal' => 'nullable|date',
            'kelamin' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'kategori_karyawan_id' => 'nullable|exists:kategori_karyawans,id'
        ]);

        DB::beginTransaction();
        try {
            Karyawan::create($request->only([
                'nama',
                'no_hp',
                'lahir_tempat',
                'lahir_tanggal',
                'kelamin',
                'alamat',
                'kategori_karyawan_id'
            ]));

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Karyawan berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('kategori');
        return response()->json($karyawan);
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:255',
            'lahir_tempat' => 'nullable|string|max:255',
            'lahir_tanggal' => 'nullable|date',
            'kelamin' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'kategori_karyawan_id' => 'nullable|exists:kategori_karyawans,id'
        ]);

        DB::beginTransaction();
        try {
            $karyawan->update($request->only([
                'nama',
                'no_hp',
                'lahir_tempat',
                'lahir_tanggal',
                'kelamin',
                'alamat',
                'kategori_karyawan_id'
            ]));

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Karyawan berhasil diupdate',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Karyawan $karyawan)
    {
        DB::beginTransaction();
        try {
            $karyawan->kategoris()->detach();
            $karyawan->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Karyawan berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
