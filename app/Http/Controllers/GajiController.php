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
    public function index()
    {
        $gajis = Gaji::with(['karyawan.kategori', 'rekeningRekapBKU'])
            ->latest()
            ->get()
            ->groupBy(function ($item) {
                return Carbon::create($item->periode_tahun, $item->periode_bulan)->format('Y-m');
            });

        $periods = collect();

        // dd($gajis?->toArray());
        foreach ($gajis as $periodKey => $gajiGroup) {
            $first = $gajiGroup->first();
            $periods->push([
                'periode_tahun' => $first->periode_tahun,
                'periode_bulan' => $first->periode_bulan,
                'tanggal_mulai' => $gajiGroup->min('tanggal_mulai'),
                'tanggal_akhir' => $gajiGroup->max('tanggal_akhir'),
                'total_karyawan' => $gajiGroup->count(),
                'total_gaji' => $gajiGroup->sum('total_gaji'),
                'status' => $gajiGroup->every(fn($gaji) => $gaji->status === 'confirm') ? 'confirm' : 'hold',
                'gaji_group' => $gajiGroup
            ]);
        }

        // dd($periods?->toArray());
        $title = 'Gaji Karyawan';
        return view('gaji.index', compact('periods', 'title'));
    }

    public function create(Request $request)
    {
        $karyawans = Karyawan::with('kategori')->get();

        $periode_bulan = $request->input('periode_bulan');
        $periode_tahun = $request->input('periode_tahun');

        $existingGajis = collect();
        $tanggal_mulai = null;
        $tanggal_akhir = null;

        if ($periode_bulan && $periode_tahun) {
            $existingGajis = Gaji::where('periode_bulan', $periode_bulan)
                ->where('periode_tahun', $periode_tahun)
                ->get()
                ->keyBy('karyawan_id');

            if ($existingGajis->isNotEmpty()) {
                $tanggal_mulai = $existingGajis->first()->tanggal_mulai?->format('Y-m-d');
                $tanggal_akhir = $existingGajis->first()->tanggal_akhir?->format('Y-m-d');
            }
        }

        $title = $periode_bulan ? 'Edit Gaji' : 'Proses Gaji';
        return view('gaji.create', compact('karyawans', 'title', 'existingGajis', 'tanggal_mulai', 'tanggal_akhir', 'periode_bulan', 'periode_tahun'));
    }

    public function show(Gaji $gaji)
    {
        $gaji->load(['karyawan.kategori', 'rekeningRekapBKU']);

        $absensis = Absensi::where('karyawan_id', $gaji->karyawan_id)
            ->where('confirmed', true)
            ->whereBetween('tanggal', [$gaji->tanggal_mulai, $gaji->tanggal_akhir])
            ->orderBy('tanggal')
            ->get();

        return response()->json([
            'success' => true,
            'gaji' => $gaji,
            'absensis' => $absensis
        ]);
    }

    public function periodDetail($periode_tahun, $periode_bulan)
    {
        $gajis = Gaji::with(['karyawan.kategori', 'rekeningRekapBKU'])
            ->where('periode_bulan', $periode_bulan)
            ->where('periode_tahun', $periode_tahun)
            ->get();

        $hadir = $gajis->sum('jumlah_hadir');
        $totalGaji = $gajis->sum('total_gaji');

        return response()->json([
            'success' => true,
            'periode' => Carbon::create($periode_tahun, $periode_bulan)->format('F Y'),
            'tanggal_mulai' => $gajis->first()->tanggal_mulai->format('d/m/Y'),
            'tanggal_akhir' => $gajis->first()->tanggal_akhir->format('d/m/Y'),
            'total_karyawan' => $gajis->count(),
            'hadir' => $hadir,
            'total_gaji' => $totalGaji,
            'status' => $gajis->every(fn($gaji) => $gaji->status === 'confirm') ? 'confirm' : 'hold',
            'gajis' => $gajis
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'karyawan_ids' => 'required|array|min:1',
            'karyawan_ids.*' => 'exists:karyawans,id',
            'periode_bulan' => 'nullable|integer',
            'periode_tahun' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $tanggalMulai = Carbon::parse($request->tanggal_mulai);
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir);

            // If editing existing period
            if ($request->has('periode_bulan') && $request->has('periode_tahun')) {
                // Delete gaji for this period that are not in the new selection
                Gaji::where('periode_bulan', $request->periode_bulan)
                    ->where('periode_tahun', $request->periode_tahun)
                    ->whereNotIn('karyawan_id', $request->karyawan_ids)
                    ->delete();
            }

            $periode_bulan = $tanggalMulai->month;
            $periode_tahun = $tanggalMulai->year;

            foreach ($request->karyawan_ids as $karyawanId) {
                $karyawan = Karyawan::with('kategori')->find($karyawanId);

                $jumlahHadir = Absensi::where('karyawan_id', $karyawanId)
                    ->where('confirmed', true)
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

    public function bulkConfirm(Request $request, $periode_tahun, $periode_bulan)
    {
        DB::beginTransaction();
        try {
            $gajis = Gaji::where('periode_bulan', $periode_bulan)
                ->where('periode_tahun', $periode_tahun)
                ->where('status', 'hold')
                ->update(['status' => 'confirm']);

            //Rekening BKU group By periode
            //Pembayaran Gaji xx Relawan periode (start_date - end_date)
            //link_bukti

            // Create BKU entry
            // $bku = RekeningRekapBKU::create([
            //     'tanggal_transaksi' => now(),
            //     'no_bukti' => null,
            //     'link_bukti' => null,
            //     'jenis_bahan' => 'Bahan Operasional',
            //     'nama_bahan' => null,
            //     'kuantitas' => 1,
            //     'satuan' => null,
            //     'supplier' => null,
            //     'uraian' => ///,
            //     'debit' => 0,
            //     'kredit' => //,
            //     'saldo' => //,
            //     'bulan' => //,
            //     'minggu' => null,
            //     'transaction_id' => null,
            // ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Semua gaji pada periode ini berhasil dikonfirmasi'
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
