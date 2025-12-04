<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKaryawan;

class KategoriKaryawanController extends Controller
{
    public function index()
    {
        $kategoris = KategoriKaryawan::withCount('karyawans')->latest()->get();
        $title = 'Master Kategori Karyawan';
        return view('kategori-karyawan.index', compact('kategoris', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nominal_gaji' => 'required|integer|min:0'
        ]);

        KategoriKaryawan::create([
            'nama' => $request->nama,
            'nominal_gaji' => $request->nominal_gaji,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori karyawan berhasil ditambahkan',
        ]);
    }

    public function show(KategoriKaryawan $kategoriKaryawan)
    {
        $kategoriKaryawan->load('karyawans');
        return response()->json($kategoriKaryawan);
    }

    public function update(Request $request, KategoriKaryawan $kategoriKaryawan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nominal_gaji' => 'required|integer|min:0'
        ]);

        $kategoriKaryawan->update([
            'nama' => $request->nama,
            'nominal_gaji' => $request->nominal_gaji,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori karyawan berhasil diupdate',
        ]);
    }

    public function destroy(KategoriKaryawan $kategoriKaryawan)
    {
        DB::beginTransaction();
        try {
            // Update all karyawans with this kategori to null
            Karyawan::where('kategori_karyawan_id', $kategoriKaryawan->id)
                ->update(['kategori_karyawan_id' => null]);

            $kategoriKaryawan->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Kategori karyawan berhasil dihapus',
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
