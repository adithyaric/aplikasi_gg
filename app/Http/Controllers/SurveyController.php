<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JawabanResponden;
use App\Models\KategoriSkm;
use App\Models\PaketSurvey;
use App\Models\Kuesioner;
use App\Models\Responden;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        $kategori = KategoriSkm::all();
        $title = 'Isi Survei Kepuasan Masyarakat (SKM)';

        return view('survey.index', compact('kategori', 'title'));
    }

    /**
     * Ambil daftar paket berdasarkan kategori (AJAX)
     */
    public function getPaket($kategori_id)
    {
        $paket = PaketSurvey::where('kategori_id', $kategori_id)
            ->select('id', 'nama')
            ->get();

        return response()->json($paket);
    }

    /**
     * Ambil daftar kuesioner berdasarkan paket (AJAX)
     */
    public function getKuesioner($paket_id)
    {
        $kuesioner = Kuesioner::where('paket_id', $paket_id)
            ->select('id', 'pertanyaan', 'opsi_jawaban')
            ->get();

        return response()->json($kuesioner);
    }

    /**
     * Simpan data responden + jawaban
     */
    public function submit(Request $request)
    {
        DB::beginTransaction();

        try {
            // 1️⃣ Simpan data responden
            $responden = Responden::create([
                'paket_id' => $request->paket_id,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'pendidikan' => $request->pendidikan,
                'pekerjaan' => $request->pekerjaan,
                'jenis_layanan' => $request->jenis_layanan,
            ]);

            // 2️⃣ Simpan jawaban kuesioner
            foreach ($request->jawaban ?? [] as $kuesioner_id => $jawaban) {
                JawabanResponden::create([
                    'responden_id' => $responden->id,
                    'kuesioner_id' => $kuesioner_id,
                    'jawaban' => $jawaban,
                ]);
            }

            DB::commit();

            return redirect()->route('survey.index')->with('success', 'Terima kasih! Jawaban Anda telah disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
