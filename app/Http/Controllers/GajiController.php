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
                return $item->tanggal_mulai->format('Ymd') . '_' . $item->tanggal_akhir->format('Ymd');
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
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_akhir = $request->input('tanggal_akhir');

        if ($tanggal_mulai && $tanggal_akhir) {
            $existingGajis = Gaji::whereDate('tanggal_mulai', $tanggal_mulai)
                ->whereDate('tanggal_akhir', $tanggal_akhir)
                ->get()
                ->keyBy('karyawan_id');
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

    public function periodDetail($tanggal_mulai, $tanggal_akhir)
    {
        $gajis = Gaji::with(['karyawan.kategori', 'rekeningRekapBKU'])
            ->whereDate('tanggal_mulai', $tanggal_mulai)
            ->whereDate('tanggal_akhir', $tanggal_akhir)
            ->get();

        $hadir = $gajis->sum('jumlah_hadir');
        $totalGaji = $gajis->sum('total_gaji');

        return response()->json([
            'success' => true,
            'periode' => Carbon::parse($tanggal_mulai)->format('d M Y') . ' - ' . Carbon::parse($tanggal_akhir)->format('d M Y'),
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
                Gaji::whereDate('tanggal_mulai', $tanggalMulai)
                    ->whereDate('tanggal_akhir', $tanggalAkhir)
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

                $mingguKe = $tanggalMulai->weekOfMonth;
                $periodeString = $tanggalMulai->format('Y-m-d') . ' s/d ' . $tanggalAkhir->format('Y-m-d');

                Gaji::updateOrCreate(
                    [
                        'karyawan_id' => $karyawanId,
                        // 'periode_bulan' => $periode_bulan,
                        // 'periode_tahun' => $periode_tahun,
                        'tanggal_mulai' => $tanggalMulai,
                        'tanggal_akhir' => $tanggalAkhir,
                    ],
                    [
                        'periode' => $periodeString,
                        'periode_minggu' => $mingguKe,
                        'periode_bulan' => $tanggalMulai->month,
                        'periode_tahun' => $tanggalMulai->year,
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

    public function bulkConfirm(Request $request, $tanggal_mulai, $tanggal_akhir)
    {
        DB::beginTransaction();
        try {
            // Get all gaji records for this period with hold status
            $gajiRecords = Gaji::with('karyawan')
                ->whereDate('tanggal_mulai', $tanggal_mulai)
                ->whereDate('tanggal_akhir', $tanggal_akhir)
                ->where('status', 'hold')
                ->get();

            if ($gajiRecords->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data gaji yang perlu dikonfirmasi'
                ], 400);
            }

            // Calculate totals
            $totalGaji = $gajiRecords->sum('total_gaji');
            $totalKaryawan = $gajiRecords->count();
            $startDate = $gajiRecords->min('tanggal_mulai');
            $endDate = $gajiRecords->max('tanggal_akhir');

            // Get previous entry for saldo calculation
            $prevEntry = RekeningRekapBKU::orderBy('tanggal_transaksi', 'desc')
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $prevSaldo = $prevEntry ? $prevEntry->saldo : 0;
            $newSaldo = $prevSaldo - $totalGaji;

            // Create single BKU entry for entire period
            $bku = RekeningRekapBKU::create([
                'tanggal_transaksi' => now(),
                'no_bukti' => null,
                'link_bukti' => null,
                'jenis_bahan' => 'Pembayaran Operasional',
                'nama_bahan' => 'Gaji Karyawan',
                'kuantitas' => $totalKaryawan,
                'satuan' => 'orang',
                'supplier' => null,
                'uraian' => "Pembayaran Gaji {$totalKaryawan} Relawan periode " .
                    \Carbon\Carbon::create($periode_tahun, $periode_bulan)->format('F Y') .
                    " ({$startDate->format('d/m/Y')} - {$endDate->format('d/m/Y')})",
                'debit' => 0,
                'kredit' => $totalGaji,
                'saldo' => $newSaldo,
                'bulan' => Carbon::parse($tanggal_mulai)->month,
                'minggu' => Carbon::parse($tanggal_mulai)->weekOfMonth,
                'transaction_id' => null,
            ]);

            // Update all gaji records with status and bku reference
            $gajiIds = $gajiRecords->pluck('id')->toArray();
            Gaji::whereIn('id', $gajiIds)
                ->update([
                    'status' => 'confirm',
                    'rekening_rekap_bku_id' => $bku->id
                ]);

            // Recalculate all entries after this one
            $nextEntries = RekeningRekapBKU::where('tanggal_transaksi', '>', $bku->tanggal_transaksi)
                ->orWhere(function ($q) use ($bku) {
                    $q->where('tanggal_transaksi', '=', $bku->tanggal_transaksi)
                        ->where('id', '>', $bku->id);
                })
                ->orderBy('tanggal_transaksi', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            $currentSaldo = $newSaldo;
            foreach ($nextEntries as $entry) {
                $currentSaldo = $currentSaldo + $entry->debit - $entry->kredit;
                $entry->update(['saldo' => $currentSaldo]);
            }

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
