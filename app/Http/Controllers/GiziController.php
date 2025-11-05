<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Gizi;
use Illuminate\Http\Request;

class GiziController extends Controller
{
    public function index()
    {
        $gizis = Gizi::latest()->get();
        $title = 'Formulir Database Gizi';
        return view('gizi.index', compact('gizis', 'title'));
    }

    public function create()
    {
        $bahanbakus = BahanBaku::doesntHave('gizi')->orderBy('nama')->get(['id', 'nama', 'kelompok']);
        $title = 'Tambah Data Gizi';
        return view('gizi.create', compact('bahanbakus', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bahan_baku_id' => 'required|exists:bahan_bakus,id|unique:gizis,bahan_baku_id',
            'nomor_pangan' => 'required|string|max:255',
            // 'rincian_bahan_makanan' => 'required|string|max:255',
            'bdd' => 'required|numeric',
        ]);

        Gizi::create($request->all());

        return redirect()->route('gizi.index')->with('success', 'Data gizi berhasil ditambahkan');
    }

    public function show(Gizi $gizi)
    {
        //
    }

    public function edit(Gizi $gizi)
    {
        $title = 'Edit Data Gizi';
        return view('gizi.edit', compact('gizi', 'title'));
    }

    public function update(Request $request, Gizi $gizi)
    {
        $request->validate([
            'nomor_pangan' => 'required|string|max:255',
            // 'rincian_bahan_makanan' => 'required|string|max:255',
            'bdd' => 'required|numeric',
        ]);

        $gizi->update($request->all());

        return redirect()->route('gizi.index')->with('success', 'Data gizi berhasil diupdate');
    }

    public function destroy(Gizi $gizi)
    {
        $gizi->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data gizi berhasil dihapus'
        ]);
    }
}
