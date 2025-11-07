<?php

namespace App\Http\Controllers;

use App\Models\KategoriSkm;
use Illuminate\Http\Request;

class KategoriSkmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = KategoriSkm::all();
        $title = 'Kategori SKM';
        return view('skm.kategori.index', compact('kategori', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriSkm::create($request->all());
        return redirect()->back()->with('toast_success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KategoriSkm  $kategoriSkm
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriSkm $kategoriSkm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriSkm  $kategoriSkm
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriSkm $kategoriSkm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KategoriSkm  $kategoriSkm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = KategoriSkm::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->back()->with('toast_success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriSkm  $kategoriSkm
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = KategoriSkm::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('toast_success', 'Data berhasil dihapus');
    }
}
