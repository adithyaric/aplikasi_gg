<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\RekeningRekapBKU;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $gajis = Gaji::with(['karyawan.kategori', 'rekeningRekapBKU'])
            ->latest()
            ->get()
            ->groupBy(['periode_tahun', 'periode_bulan']);

        dd($gajis?->toArray());
        $title = 'Gaji Karyawan';
        return view('gaji.index', compact('gajis', 'title'));
    }

    public function create()
    {
        $karyawans = Karyawan::with('kategori')->get();
        $title = 'Proses Gaji';
        return view('gaji.create', compact('karyawans', 'title'));
    }

    public function show(Gaji $gaji)
    {
        $gaji->load(['karyawan.kategori', 'rekeningRekapBKU']);

        $absensis = Absensi::where('karyawan_id', $gaji->karyawan_id)
            ->whereBetween('tanggal', [$gaji->tanggal_mulai, $gaji->tanggal_akhir])
            ->orderBy('tanggal')
            ->get();

        return response()->json([
            'success' => true,
            'gaji' => $gaji,
            'absensis' => $absensis
        ]);
    }

    public function confirm(Gaji $gaji)
    {
        if ($gaji->status === 'confirm') {
            return response()->json([
                'success' => false,
                'message' => 'Gaji sudah dikonfirmasi'
            ], 400);
        }

        DB::beginTransaction();
        try {
            //Rekening BKU group By periode
            //Pembayaran Gaji xx Relawan periode (start_date - end_date)
            //link_bukti
            $gaji->update(['status' => 'confirm']);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Gaji berhasil dikonfirmasi dan dicatat ke BKU'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'karyawan_ids' => 'required|array|min:1',
            'karyawan_ids.*' => 'exists:karyawans,id',
        ]);

        DB::beginTransaction();
        try {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai);
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir);
            $periode_bulan = $tanggalMulai->month;
            $periode_tahun = $tanggalMulai->year;

            foreach ($request->karyawan_ids as $karyawanId) {
                $karyawan = Karyawan::with('kategori')->find($karyawanId);

                $jumlahHadir = Absensi::where('karyawan_id', $karyawanId)
                    ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
                    ->where('status', 'hadir')
                    ->count();

                $nominalPerHari = $karyawan->kategori->nominal_gaji;
                $totalGaji = $jumlahHadir * $nominalPerHari;

                Gaji::updateOrCreate(
                    [
                        'karyawan_id' => $karyawanId,
                        'periode_bulan' => $periode_bulan,
                        'periode_tahun' => $periode_tahun,
                    ],
                    [
                        'tanggal_mulai' => $tanggalMulai,
                        'tanggal_akhir' => $tanggalAkhir,
                        'jumlah_hadir' => $jumlahHadir,
                        'nominal_per_hari' => $nominalPerHari,
                        'total_gaji' => $totalGaji,
                        'status' => 'hold',
                    ]
                );
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Gaji berhasil diproses'
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
