<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolahs = Sekolah::latest()->get([
            'id',
            'nama',
            'nama_pic',
            'nomor',
            'jarak',
            'long',
            'lat',
        ]);
        $title = 'Master Sekolah';
        return view('sekolah.index', compact('sekolahs', 'title'));
    }

    public function create()
    {
        //using modal create on index.blade.php
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nama_pic' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'jarak' => 'required|numeric',
            'alamat' => 'nullable|string',
            'long' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
        ]);

        Sekolah::create([
            'nama' => $request->nama,
            'nama_pic' => $request->nama_pic,
            'nomor' => $request->nomor,
            'jarak' => $request->jarak,
            'alamat' => $request->alamat,
            'long' => $request->long,
            'lat' => $request->lat,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sekolah berhasil ditambahkan'
        ]);
    }

    public function show(Sekolah $sekolah)
    {
        return response()->json($sekolah);
    }

    public function edit(Sekolah $sekolah)
    {
        return response()->json($sekolah);
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nama_pic' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'jarak' => 'required|numeric',
            'alamat' => 'nullable|string',
            'long' => 'nullable|numeric',
            'lat' => 'nullable|numeric',
        ]);

        $sekolah->update([
            'nama' => $request->nama,
            'nama_pic' => $request->nama_pic,
            'nomor' => $request->nomor,
            'jarak' => $request->jarak,
            'alamat' => $request->alamat,
            'long' => $request->long,
            'lat' => $request->lat,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sekolah berhasil diupdate'
        ]);
    }

    public function destroy(Sekolah $sekolah)
    {
        DB::beginTransaction();
        try {
            // if ($sekolah->bebanSewas()->count() > 0) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Sekolah tidak dapat dihapus karena masih digunakan dalam Beban Sewa'
            //     ], 422);
            // }

            $sekolah->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Sekolah berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
