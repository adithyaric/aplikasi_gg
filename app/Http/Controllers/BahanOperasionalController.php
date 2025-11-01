<?php

namespace App\Http\Controllers;

use App\Models\BahanOperasional;
use Illuminate\Http\Request;

class BahanOperasionalController extends Controller
{
    public function index()
    {
        $bahanoperasionals = BahanOperasional::latest()->get([
            'id',
            'nama',
            'satuan',
        ]);
        $title = 'Master Bahan Operasional';
        return view('bahan-operasional.index', compact('bahanoperasionals', 'title'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
        ]);

        BahanOperasional::create([
            'nama' => $request->nama,
            'satuan' => $request->satuan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bahan operasional berhasil ditambahkan'
        ]);
    }

    public function show(BahanOperasional $bahanoperasional)
    {
        //
    }

    public function edit(BahanOperasional $bahanoperasional)
    {
        return response()->json($bahanoperasional);
    }

    public function update(Request $request, BahanOperasional $bahanoperasional)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
        ]);

        $bahanoperasional->update([
            'nama' => $request->nama,
            'satuan' => $request->satuan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bahan operasional berhasil diupdate'
        ]);
    }

    public function destroy(BahanOperasional $bahanoperasional)
    {
        $bahanoperasional->delete();
        return response()->json([
            'success' => true,
            'message' => 'Bahan operasional berhasil dihapus'
        ]);
    }
}
