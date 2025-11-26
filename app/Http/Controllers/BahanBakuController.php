<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BahanBakuController extends Controller
{
    public function index()
    {
        $bahanbakus = BahanBaku::latest()->get([
            'id',
            'nama',
            'kelompok',
            'jenis',
            'kategori',
            'satuan',
            'merek',
            'gov_price',
            'ukuran',
        ]);
        $categories = Category::pluck('name')->all();
        $title = 'Master Bahan Baku';
        return view('bahan-baku.index', compact('bahanbakus', 'categories', 'title'));
    }

    public function create()
    {
        //using modal create on index.blade.php
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'kategori' => 'nullable|array',
            'merek' => 'required|string|max:255',
            'gov_price' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:255',
        ]);

        // Save categories
        if ($request->kategori) {
            foreach ($request->kategori as $kat) {
                Category::firstOrCreate(['name' => $kat]);
            }
        }

        BahanBaku::create([
            'nama' => $request->nama,
            'kelompok' => $request->kelompok,
            'jenis' => $request->jenis,
            'satuan' => $request->satuan,
            'kategori' => $request->kategori,
            'merek' => $request->merek,
            'gov_price' => $request->gov_price,
            'ukuran' => $request->ukuran,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bahan baku berhasil ditambahkan'
        ]);
    }

    public function show(BahanBaku $bahanbaku)
    {
        return response()->json($bahanbaku);
    }

    public function edit(BahanBaku $bahanbaku)
    {
        return response()->json($bahanbaku);
    }

    public function update(Request $request, BahanBaku $bahanbaku)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelompok' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'kategori' => 'nullable|array',
            'merek' => 'required|string|max:255',
            'gov_price' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:255',
        ]);

        // Save categories
        if ($request->kategori) {
            foreach ($request->kategori as $kat) {
                Category::firstOrCreate(['name' => $kat]);
            }
        }

        $bahanbaku->update([
            'nama' => $request->nama,
            'kelompok' => $request->kelompok,
            'jenis' => $request->jenis,
            'satuan' => $request->satuan,
            'kategori' => $request->kategori,
            'merek' => $request->merek,
            'gov_price' => $request->gov_price,
            'ukuran' => $request->ukuran,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bahan baku berhasil diupdate'
        ]);
    }

    public function destroy(BahanBaku $bahanbaku)
    {
        DB::beginTransaction();
        try {
            if ($bahanbaku->menus()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bahan Baku tidak dapat dihapus karena masih digunakan dalam Menu'
                ], 422);
            }
            if ($bahanbaku->gizi()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bahan Baku tidak dapat dihapus karena masih digunakan dalam Gizi'
                ], 422);
            }

            $bahanbaku->delete();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Bahan Baku berhasil dihapus'
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
