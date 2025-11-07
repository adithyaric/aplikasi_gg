<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Surat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surats = Surat::latest()->get();
        $title = 'Laporan Kehilangan';
        return view('surats.index', compact('surats', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Laporan Kehilangan';
        $categories = Category::all();
        $users = User::where('role', 'anggota')->get();
        return view('surats.create', compact('title', 'categories', 'users'));
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
            'name' => 'required|string|max:255',
            'nik' => 'required',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'agama' => 'required',
            'warganegara' => 'required',
            'pekerjaan' => 'required|string|max:100',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'category_id' => 'required',
            'tgl_kejadian' => 'required',
            'ttd_id' => 'required',
            'desc' => 'required|string',
        ]);

        // Noreg Surat
        $now = Carbon::now();
        $bulan = $now->format('m');
        $tahun = $now->format('Y');

        $countThisMonth = Surat::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->count();

        $nextNumber = $countThisMonth + 1;
        $noreg = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        Surat::create([
            'user_id' => Auth::id(),
            'noreg' => $noreg,
            'name' => $request->name,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jk' => $request->jk,
            'agama' => $request->agama,
            'warganegara' => $request->warganegara,
            'pekerjaan' => $request->pekerjaan,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'category_id' => $request->category_id,
            'tgl_kejadian' => $request->tgl_kejadian,
            'ttd_id' => $request->ttd_id,
            'desc' => $request->desc,
        ]);

        return redirect()->route('surats.index')->with('toast_success', 'Data berhasil diterbitkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function show(Surat $surat)
    {
        // Format nomor surat
        $bulan = $surat->created_at->format('m');
        $tahun = $surat->created_at->format('Y');

        $romawi = [
            '01' => 'I',
            '02' => 'II',
            '03' => 'III',
            '04' => 'IV',
            '05' => 'V',
            '06' => 'VI',
            '07' => 'VII',
            '08' => 'VIII',
            '09' => 'IX',
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII',
        ];

        $bulanRomawi = $romawi[$bulan];
        $no_surat = "SKTLK/{$surat->noreg}/{$bulanRomawi}/{$tahun}/SPKT/POLRES PACITAN/POLDA JAWA TIMUR";

        $title = 'Laporan Kehilangan';
        $categories = Category::all();
        $users = User::where('role', 'anggota')->get();
        $surat = $surat;
        return view('surats.detail', compact('title', 'categories', 'users', 'surat', 'no_surat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function edit(Surat $surat)
    {
        $title = 'Laporan Kehilangan';
        $categories = Category::all();
        $users = User::where('role', 'anggota')->get();
        $surat = $surat;
        return view('surats.edit', compact('title', 'categories', 'users', 'surat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required',
            'tempat_lahir' => 'required|string',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'agama' => 'required',
            'warganegara' => 'required',
            'pekerjaan' => 'required|string',
            'no_telp' => 'required|string',
            'alamat' => 'required|string|max:255',
            'category_id' => 'required',
            'tgl_kejadian' => 'required',
            'ttd_id' => 'required',
            'desc' => 'required|string',
        ]);

        // Ambil data surat berdasarkan ID
        $surat = Surat::findOrFail($id);

        // Update data surat
        $surat->update([
            'name' => $request->name,
            'nik' => $request->nik,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'jk' => $request->jk,
            'agama' => $request->agama,
            'warganegara' => $request->warganegara,
            'pekerjaan' => $request->pekerjaan,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'category_id' => $request->category_id,
            'tgl_kejadian' => $request->tgl_kejadian,
            'ttd_id' => $request->ttd_id,
            'desc' => $request->desc,
        ]);

        return redirect()->route('surats.index')->with('toast_success', 'Data surat berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Surat  $surat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Surat::findOrFail($id);

        $category->delete();

        return redirect()->route('surats.index')->with('toast_success', 'Data berhasil dihapus.');
    }

    public function cetak($id)
{
    $surat = Surat::with('category', 'ttd')->findOrFail($id);

    // Buat format nomor surat
    $bulan = $surat->created_at->format('m');
    $tahun = $surat->created_at->format('Y');

    $romawi = [
        '01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV',
        '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII',
        '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII',
    ];

    $bulanRomawi = $romawi[$bulan];
    $no_surat = "SKTLK/{$surat->noreg}/{$bulanRomawi}/{$tahun}/SPKT/POLRES PACITAN/POLDA JAWA TIMUR";

    // Format tanggal dengan zona waktu Indonesia
    $tanggal = Carbon::parse($surat->created_at)->locale('id')->translatedFormat('d F Y');
    // $tanggalKejadian = Carbon::parse($surat->tgl_kejadian)->translatedFormat('d F Y');

    // Load view PDF
    $pdf = Pdf::loadView('surats.pdf', compact('surat', 'no_surat', 'tanggal'))
        ->setPaper('A4', 'portrait');

    // Kembalikan langsung untuk ditampilkan (bisa juga ->download('surat.pdf'))
    return $pdf->stream("Surat_{$surat->noreg}.pdf");
}
}
