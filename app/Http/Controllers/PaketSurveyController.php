<?php

namespace App\Http\Controllers;

use App\Models\KategoriSkm;
use App\Models\Kuesioner;
use App\Models\PaketSurvey;
use Illuminate\Http\Request;

class PaketSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paket = PaketSurvey::with('kategori')->get();
        $kategori = KategoriSkm::all();
        $title = 'Paket Kuesioner SKM';
    return view('skm.paket.index', compact('paket', 'kategori', 'title'));
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
            'kategori_id' => 'required|exists:kategori_skm,id',
            'nama' => 'required|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|string',
        ]);

        PaketSurvey::create($request->all());
        return redirect()->back()->with('toast_success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaketSurvey  $paketSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(PaketSurvey $paket)
    {
        $title = 'Kuesioner SKM';
        $pakets = $paket;
        // $kuesioner = Kuesioner::with($paket)->get();

        $kuesioner = $pakets->kuesioner()->get();
        // dd($kuesioner);
        return view('skm.paket.show', compact('title', 'paket', 'kuesioner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaketSurvey  $paketSurvey
     * @return \Illuminate\Http\Response
     */
    public function edit(PaketSurvey $paketSurvey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaketSurvey  $paketSurvey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_skm,id',
            'nama' => 'required|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|string',
        ]);

        $paket = PaketSurvey::findOrFail($id);
        $paket->update($request->all());

        return redirect()->back()->with('toast_success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaketSurvey  $paketSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paket = PaketSurvey::findOrFail($id);
        $paket->delete();

        return redirect()->back()->with('toast_success', 'Data berhasil dihapus');
    }
}
