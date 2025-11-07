<?php

namespace App\Http\Controllers;

use App\Models\Kuesioner;
use App\Models\PaketSurvey;
use Illuminate\Http\Request;

class KuesionerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'paket_id' => 'required|exists:paket_survey,id',
            'pertanyaan' => 'required|string',
            'opsi_jawaban' => 'nullable|array'
        ]);

        Kuesioner::create([
            'paket_id' => $request->paket_id,
            'pertanyaan' => $request->pertanyaan,
            'opsi_jawaban' => $request->opsi_jawaban
        ]);

        return redirect()->back()->with('toast_success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kuesioner  $kuesioner
     * @return \Illuminate\Http\Response
     */
    public function show(Kuesioner $kuesioner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kuesioner  $kuesioner
     * @return \Illuminate\Http\Response
     */
    public function edit(Kuesioner $kuesioner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kuesioner  $kuesioner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket_survey,id',
            'pertanyaan' => 'required|string',
            'opsi_jawaban' => 'nullable|array'
        ]);

        $kuesioner = Kuesioner::findOrFail($id);
        $kuesioner->update([
            'paket_id' => $request->paket_id,
            'pertanyaan' => $request->pertanyaan,
            'opsi_jawaban' => $request->opsi_jawaban
        ]);

        return redirect()->back()->with('toast_success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kuesioner  $kuesioner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kuesioner = Kuesioner::findOrFail($id);
        $kuesioner->delete();

        return redirect()->back()->with('toast_success', 'Data berhasil dihapus');
    }
}
