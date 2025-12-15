<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\RekeningKoranVa;
use App\Models\RekeningRekapBKU;
use App\Models\Sekolah;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get current date and calculate periods
        $now = now();
        $twoWeeksAgo = $now->copy()->subDays(14);
        $oneWeekAgo = $now->copy()->subDays(7);

        // 1. Total Pemasukan (from RekeningRekapBKU debit column)
        $totalPemasukan = RekeningRekapBKU::whereIn('jenis_bahan', [
            'Penerimaan BGN',
            'Penerimaan Yayasan',
            'Penerimaan Pihak Lainnya'
        ])->sum('debit');

        // 2. Total Pengeluaran (from RekeningRekapBKU kredit column for expenses)
        $totalPengeluaran = RekeningRekapBKU::whereIn('jenis_bahan', [
            'Bahan Pokok',
            'Bahan Operasional',
            'Pembayaran Sewa'
        ])->sum('kredit');

        // 3. Total Seluruh Porsi (from Anggaran)
        $totalPorsi = Anggaran::sum('total_porsi');

        // 4. Pemasukan 2 Mingguan
        $pemasukan2Mingguan = RekeningRekapBKU::whereIn('jenis_bahan', [
            'Penerimaan BGN',
            'Penerimaan Yayasan',
            'Penerimaan Pihak Lainnya'
        ])
            ->where('tanggal_transaksi', '>=', $twoWeeksAgo)
            ->sum('debit');

        // 5. Pengeluaran 2 Mingguan
        $pengeluaran2Mingguan = RekeningRekapBKU::whereIn('jenis_bahan', [
            'Bahan Pokok',
            'Bahan Operasional',
            'Pembayaran Sewa'
        ])
            ->where('tanggal_transaksi', '>=', $twoWeeksAgo)
            ->sum('kredit');

        // 6. Porsi 2 Mingguan (from anggaran within last 2 weeks)
        $porsi2Mingguan = Anggaran::where(function ($query) use ($twoWeeksAgo, $now) {
            $query->whereBetween('start_date', [$twoWeeksAgo, $now])
                ->orWhereBetween('end_date', [$twoWeeksAgo, $now])
                ->orWhere(function ($q) use ($twoWeeksAgo, $now) {
                    $q->where('start_date', '<=', $twoWeeksAgo)
                        ->where('end_date', '>=', $now);
                });
        })->sum('total_porsi');

        // 7. Saldo Saat Ini (from last RekeningRekapBKU entry)
        $lastRekening = RekeningRekapBKU::latest('tanggal_transaksi')->latest('id')->first();
        $saldoSaatIni = $lastRekening ? $lastRekening->saldo : 0;

        // 8. Ringkasan Anggaran - Calculate total budget
        $anggaranData = Anggaran::all();
        $totalAnggaran = 0;
        $totalRealisasi = $totalPengeluaran;

        foreach ($anggaranData as $anggaran) {
            $days = $anggaran->start_date->diffInDays($anggaran->end_date) + 1;
            $totalAnggaran += ($anggaran->budget_porsi_8k + $anggaran->budget_porsi_10k
                + $anggaran->budget_operasional + $anggaran->budget_sewa) * $days;
        }

        $terpakaiPersen = $totalAnggaran > 0 ? ($totalRealisasi / $totalAnggaran) * 100 : 0;
        $sisaAnggaran = $totalAnggaran - $totalRealisasi;

        // 9. Porsi Breakdown
        $porsi10k = Anggaran::sum('porsi_10k');
        $porsi8k = Anggaran::sum('porsi_8k');

        // 10. Riwayat Transaksi BKU (7 hari terakhir)
        $riwayatTransaksi = RekeningRekapBKU::with('transaction.order')
            ->where('tanggal_transaksi', '>=', $oneWeekAgo)
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(7)
            ->get();

        // 11. Rekonsiliasi data for table (last 5 entries from reconciliation)
        $rekonsiliasiData = $this->getRekonsiliasiData();

        // 12. Chart data (for Pemasukan vs Pengeluaran)
        // $chartData = $this->getChartData();

        // 13. Chart data for Anggaran vs Realisasi
        $anggaranRealisasiData = $this->getAnggaranRealisasiData();

        return view('dashboard', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'totalPorsi',
            'pemasukan2Mingguan',
            'pengeluaran2Mingguan',
            'porsi2Mingguan',
            'saldoSaatIni',
            'totalAnggaran',
            'totalRealisasi',
            'terpakaiPersen',
            'sisaAnggaran',
            'porsi10k',
            'porsi8k',
            'riwayatTransaksi',
            'rekonsiliasiData',
            // 'chartData',
            'anggaranRealisasiData'
        ));
    }

    private function getRekonsiliasiData()
    {
        // Get last 5 reconciliation entries using existing logic
        $rekeningKorans = RekeningKoranVa::with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(50)
            ->get();

        $rekeningBKUs = RekeningRekapBKU::with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(50)
            ->get();

        $koranByDate = $rekeningKorans->groupBy(function ($item) {
            return $item->tanggal_transaksi->format('Y-m-d');
        })->map(function ($group) {
            return [
                'count' => $group->count(),
                'total_kredit' => $group->sum('kredit'),
                'total_debit' => $group->sum('debit'),
            ];
        });

        $bkuByDate = $rekeningBKUs->groupBy(function ($item) {
            return $item->tanggal_transaksi->format('Y-m-d');
        })->map(function ($group) {
            return [
                'count' => $group->count(),
                'total_debit' => $group->sum('debit'),
                'total_kredit' => $group->sum('kredit'),
            ];
        });

        $allDates = collect(array_merge(
            $koranByDate->keys()->toArray(),
            $bkuByDate->keys()->toArray()
        ))->unique()->sort()->reverse()->take(5);

        $reconciliationData = [];

        foreach ($allDates as $date) {
            $koran = $koranByDate[$date] ?? ['count' => 0, 'total_kredit' => 0, 'total_debit' => 0];
            $bku = $bkuByDate[$date] ?? ['count' => 0, 'total_debit' => 0, 'total_kredit' => 0];

            $selisih = ($koran['total_kredit'] + $koran['total_debit'])
                - ($bku['total_debit'] + $bku['total_kredit']);

            $reconciliationData[] = [
                'tanggal' => \Carbon\Carbon::parse($date)->translatedFormat('j F Y'),
                'jml_transaksi' => $koran['count'] + $bku['count'],
                'selisih' => $selisih,
                'status' => abs($selisih) < 0.01 ? 'Match' : 'No Match'
            ];
        }

        return $reconciliationData;
    }

    public function getChartData(Request $request)
    {
        $filter = $request->input('filter', 'week');

        // Calculate date range based on filter
        $now = now();
        switch ($filter) {
            case 'week':
                $startDate = $now->copy()->subDays(7);
                $format = 'd M';
                break;
            case 'month':
                $startDate = $now->copy()->subDays(30);
                $format = 'd M';
                break;
            case 'year':
                $startDate = $now->copy()->subYear();
                $format = 'M Y';
                break;
            default:
                $startDate = $now->copy()->subDays(7);
                $format = 'd M';
        }

        // Pemasukan data
        $pemasukanData = RekeningRekapBKU::whereIn('jenis_bahan', [
            'Penerimaan BGN',
            'Penerimaan Yayasan',
            'Penerimaan Pihak Lainnya'
        ])
            ->where('tanggal_transaksi', '>=', $startDate)
            ->selectRaw('DATE(tanggal_transaksi) as date, SUM(debit) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) use ($format) {
                return [\Carbon\Carbon::parse($item->date)->format($format) => $item->total];
            });

        // Pengeluaran data
        $pengeluaranData = RekeningRekapBKU::whereIn('jenis_bahan', [
            'Bahan Pokok',
            'Bahan Operasional',
            'Pembayaran Sewa'
        ])
            ->where('tanggal_transaksi', '>=', $startDate)
            ->selectRaw('DATE(tanggal_transaksi) as date, SUM(kredit) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) use ($format) {
                return [\Carbon\Carbon::parse($item->date)->format($format) => $item->total];
            });

        // Get all dates in range
        $allDates = [];
        $current = $startDate->copy();
        while ($current <= $now) {
            $allDates[] = $current->format($format);
            $current->addDay();
        }
        $allDates = array_unique($allDates);

        // Fill missing dates with 0
        $categories = [];
        $pemasukanSeries = [];
        $pengeluaranSeries = [];

        foreach ($allDates as $date) {
            $categories[] = $date;
            $pemasukanSeries[] = $pemasukanData[$date] ?? 0;
            $pengeluaranSeries[] = $pengeluaranData[$date] ?? 0;
        }

        // Anggaran vs Realisasi
        $anggaranData = [];
        $realisasiData = [];

        $anggarans = Anggaran::where('start_date', '>=', $startDate)
            ->orWhere('end_date', '>=', $startDate)
            ->get()
            ->groupBy(function ($item) use ($filter) {
                if ($filter === 'year') {
                    return $item->start_date->format('M Y');
                }
                return $item->start_date->format('d M');
            });

        foreach ($anggarans as $date => $group) {
            $totalAnggaran = $group->sum(function ($anggaran) {
                $days = max(1, $anggaran->start_date->diffInDays($anggaran->end_date) + 1);
                return ($anggaran->budget_porsi_8k + $anggaran->budget_porsi_10k
                    + $anggaran->budget_operasional + $anggaran->budget_sewa) * $days;
            });
            $anggaranData[$date] = $totalAnggaran;
        }

        $realisasi = RekeningRekapBKU::whereIn('jenis_bahan', [
            'Bahan Pokok',
            'Bahan Operasional',
            'Pembayaran Sewa'
        ])
            ->where('tanggal_transaksi', '>=', $startDate)
            ->selectRaw('DATE(tanggal_transaksi) as date, SUM(kredit) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(function ($item) use ($format) {
                return [\Carbon\Carbon::parse($item->date)->format($format) => $item->total];
            });

        $anggaranCategories = [];
        $anggaranSeries = [];
        $realisasiSeries = [];

        foreach ($allDates as $date) {
            $anggaranCategories[] = $date;
            $anggaranSeries[] = $anggaranData[$date] ?? 0;
            $realisasiSeries[] = $realisasi[$date] ?? 0;
        }

        // Distribusi Porsi
        $porsiData = Anggaran::where('start_date', '>=', $startDate)
            ->orWhere('end_date', '>=', $startDate)
            ->get();

        $distribusiCategories = [];
        $distribusiSeries = [];

        foreach ($porsiData as $anggaran) {
            $current = $anggaran->start_date->copy();
            $end = $anggaran->end_date->copy();

            while ($current <= $end && $current >= $startDate && $current <= $now) {
                $dateKey = $current->format($format);
                $distribusiCategories[] = $dateKey;
                $distribusiSeries[] = $anggaran->total_porsi;
                $current->addDay();
            }
        }

        return response()->json([
            'pemasukan' => [
                'categories' => $categories,
                'series' => $pemasukanSeries,
            ],
            'pengeluaran' => [
                'categories' => $categories,
                'series' => $pengeluaranSeries,
            ],
            'anggaran' => [
                'categories' => $anggaranCategories,
                'anggaranSeries' => $anggaranSeries,
                'realisasiSeries' => $realisasiSeries,
            ],
            'distribusi' => [
                'categories' => $distribusiCategories,
                'series' => $distribusiSeries,
            ],
        ]);
    }

    private function getAnggaranRealisasiData()
    {
        // Get anggaran and realisasi by week for chart
        $startDate = now()->subDays(90); // Last 90 days

        // Group anggaran by week
        $anggaranWeekly = Anggaran::where('start_date', '>=', $startDate)
            ->get()
            ->groupBy(function ($item) {
                return $item->start_date->format('Y-W'); // Year-Week
            })
            ->map(function ($group) {
                return $group->sum(function ($anggaran) {
                    $days = $anggaran->start_date->diffInDays($anggaran->end_date) + 1;
                    return ($anggaran->budget_porsi_8k + $anggaran->budget_porsi_10k
                        + $anggaran->budget_operasional + $anggaran->budget_sewa) * $days;
                });
            });

        // Group realisasi by week
        $realisasiWeekly = RekeningRekapBKU::whereIn('jenis_bahan', [
            'Bahan Pokok',
            'Bahan Operasional',
            'Pembayaran Sewa'
        ])
            ->where('tanggal_transaksi', '>=', $startDate)
            ->selectRaw('YEARWEEK(tanggal_transaksi, 1) as week, SUM(kredit) as total')
            ->groupBy('week')
            ->orderBy('week')
            ->get()
            ->keyBy('week');

        return [
            'anggaran' => $anggaranWeekly,
            'realisasi' => $realisasiWeekly
        ];
    }

    public function rekonsiliasi()
    {
        $rekeningKorans = RekeningKoranVa::with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $rekeningBKUs = RekeningRekapBKU::with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Group by date and calculate summaries
        $koranByDate = $rekeningKorans->groupBy(function ($item) {
            return $item->tanggal_transaksi->format('Y-m-d');
        })->map(function ($group) {
            return [
                'count' => $group->count(),
                'total_kredit' => $group->sum('kredit'),
                'total_debit' => $group->sum('debit'),
                'items' => $group
            ];
        });

        $bkuByDate = $rekeningBKUs->groupBy(function ($item) {
            return $item->tanggal_transaksi->format('Y-m-d');
        })->map(function ($group) {
            return [
                'count' => $group->count(),
                'total_debit' => $group->sum('debit'),
                'total_kredit' => $group->sum('kredit'),
                'items' => $group
            ];
        });

        // Get all unique dates
        $allDates = collect(array_merge(
            $koranByDate->keys()->toArray(),
            $bkuByDate->keys()->toArray()
        ))->unique()->sort();

        // Build reconciliation data
        $reconciliationData = [];
        $no = 1;

        foreach ($allDates as $date) {
            $koran = $koranByDate[$date] ?? ['count' => 0, 'total_kredit' => 0, 'total_debit' => 0];
            $bku = $bkuByDate[$date] ?? ['count' => 0, 'total_debit' => 0, 'total_kredit' => 0];

            // Calculate difference (adjust based on your logic - using kredit for Koran and debit for BKU)
            $selisih = ($koran['total_kredit'] + $koran['total_debit']) - ($bku['total_debit'] + $bku['total_kredit']);

            $reconciliationData[] = [
                'no' => $no++,
                'tanggal' => \Carbon\Carbon::parse($date)->translatedFormat('j F Y'),
                'jml_rek' => $koran['count'],
                'nilai_rek' => ($koran['total_kredit'] + $koran['total_debit']),
                'jml_buku' => $bku['count'],
                'nilai_buku' => ($bku['total_debit'] + $bku['total_kredit']),
                'selisih' => $selisih,
                'status' => abs($selisih) < 0.01 ? 'Match' : 'No Match' // Using epsilon for float comparison
            ];
        }

        // dd([
        //     'reconciliationData' => $reconciliationData,
        //     'rekeningKorans' => $rekeningKorans?->toArray(),
        //     'rekeningBKUs' => $rekeningBKUs?->toArray()
        // ]);
        return view('rekonsiliasi', [
            'reconciliationData' => $reconciliationData,
            'rekeningKorans' => $rekeningKorans,
            'rekeningBKUs' => $rekeningBKUs
        ]);
    }

    public function titikDistribusi(Request $request)
    {
        $schools = Sekolah::get([
            'id',
            'nama',
            'nama_pic',
            'nomor',
            'jarak',
            'alamat',
            'long',
            'lat',
            'porsi_8k',
            'porsi_10k',
        ]);
        $suppliers = Supplier::get([
            'id',
            'nama',
            'no_hp',
            'bank_no_rek',
            'bank_nama',
            'alamat',
            'long',
            'lat',
            'products',
        ]);
        return view('titik-distribusi', [
            'schools' => $schools,
            'suppliers' => $suppliers
        ]);
    }
}
