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
        $settingPageId = $request->input('setting_page_id');
        $user = auth()->user();

        // For super admin, get all setting pages for dropdown
        $settingPages = null;
        if ($user->isSuperAdmin()) {
            $settingPages = \App\Models\SettingPage::all();

            // If no filter selected, use all data
            if (!$settingPageId) {
                // Queries will use withoutGlobalScope
            }
        }

        // Get current date and calculate periods
        $now = now();
        $twoWeeksAgo = $now->copy()->subDays(14);
        $oneWeekAgo = $now->copy()->subDays(7);

        // Helper function to apply scope
        $applyScope = function ($query) use ($user, $settingPageId) {
            if ($user->isSuperAdmin()) {
                $query->withoutGlobalScope('setting_page');
                if ($settingPageId) {
                    $query->where('setting_page_id', $settingPageId);
                }
            }
            return $query;
        };

        // 1. Total Pemasukan
        $totalPemasukan = $applyScope(RekeningRekapBKU::query())
            ->whereIn('jenis_bahan', [
                'Penerimaan BGN',
                'Penerimaan Yayasan',
                'Penerimaan Pihak Lainnya'
            ])->sum('debit');

        // 2. Total Pengeluaran
        $totalPengeluaran = $applyScope(RekeningRekapBKU::query())
            ->whereIn('jenis_bahan', [
                'Bahan Pokok',
                'Bahan Operasional',
                'Pembayaran Sewa'
            ])->sum('kredit');

        // 3. Total Seluruh Porsi
        $totalPorsi = $applyScope(Anggaran::query())->sum('total_porsi');

        // 4. Pemasukan 2 Mingguan
        $pemasukan2Mingguan = $applyScope(RekeningRekapBKU::query())
            ->whereIn('jenis_bahan', [
                'Penerimaan BGN',
                'Penerimaan Yayasan',
                'Penerimaan Pihak Lainnya'
            ])
            ->where('tanggal_transaksi', '>=', $twoWeeksAgo)
            ->sum('debit');

        // 5. Pengeluaran 2 Mingguan
        $pengeluaran2Mingguan = $applyScope(RekeningRekapBKU::query())
            ->whereIn('jenis_bahan', [
                'Bahan Pokok',
                'Bahan Operasional',
                'Pembayaran Sewa'
            ])
            ->where('tanggal_transaksi', '>=', $twoWeeksAgo)
            ->sum('kredit');

        // 6. Porsi 2 Mingguan
        $porsi2Mingguan = $applyScope(Anggaran::query())
            ->where(function ($query) use ($twoWeeksAgo, $now) {
                $query->whereBetween('start_date', [$twoWeeksAgo, $now])
                    ->orWhereBetween('end_date', [$twoWeeksAgo, $now])
                    ->orWhere(function ($q) use ($twoWeeksAgo, $now) {
                        $q->where('start_date', '<=', $twoWeeksAgo)
                            ->where('end_date', '>=', $now);
                    });
            })->sum('total_porsi');

        // 7. Saldo Saat Ini
        $lastRekening = $applyScope(RekeningRekapBKU::query())
            ->latest('tanggal_transaksi')
            ->latest('id')
            ->first();
        $saldoSaatIni = $lastRekening ? $lastRekening->saldo : 0;

        // 8. Ringkasan Anggaran
        $anggaranData = $applyScope(Anggaran::query())->get();
        $totalAnggaran = 0;
        $totalRealisasi = $totalPengeluaran;

        foreach ($anggaranData as $anggaran) {
            // $days = $anggaran->start_date->diffInDays($anggaran->end_date) + 1; //$days skip sabtu & minggu
            $days = $this->getBusinessDays($anggaran->start_date, $anggaran->end_date);
            $totalAnggaran += ($anggaran->budget_porsi_8k + $anggaran->budget_porsi_10k
                + $anggaran->budget_operasional + $anggaran->budget_sewa) * $days;
        }

        $terpakaiPersen = $totalAnggaran > 0 ? ($totalRealisasi / $totalAnggaran) * 100 : 0;
        $sisaAnggaran = $totalAnggaran - $totalRealisasi;

        // 9. Porsi Breakdown
        $porsi10k = $applyScope(Anggaran::query())->sum('porsi_10k');
        $porsi8k = $applyScope(Anggaran::query())->sum('porsi_8k');

        // 10. Riwayat Transaksi BKU
        $riwayatTransaksi = $applyScope(RekeningRekapBKU::query())
            ->with('transaction.order')
            ->where('tanggal_transaksi', '>=', $oneWeekAgo)
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(7)
            ->get();

        // 11. Rekonsiliasi data
        $rekonsiliasiData = $this->getRekonsiliasiData($settingPageId);

        // 13. Chart data
        $anggaranRealisasiData = $this->getAnggaranRealisasiData($settingPageId);

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
            'anggaranRealisasiData',
            'settingPages',
            'settingPageId'
        ));
    }

    private function getRekonsiliasiData($settingPageId = null)
    {
        $user = auth()->user();

        // Build base queries
        $koranQuery = RekeningKoranVa::query();
        $bkuQuery = RekeningRekapBKU::query();

        // Apply filters for super admin
        if ($user->isSuperAdmin()) {
            $koranQuery->withoutGlobalScope('setting_page');
            $bkuQuery->withoutGlobalScope('setting_page');

            if ($settingPageId) {
                $koranQuery->where('rekening_koran_vas.setting_page_id', $settingPageId);
                $bkuQuery->where('rekening_rekap_bku.setting_page_id', $settingPageId);
            }
        }

        $rekeningKorans = $koranQuery
            ->orderBy('tanggal_transaksi', 'desc')
            // ->take(50)
            ->get();

        $rekeningBKUs = $bkuQuery
            ->orderBy('tanggal_transaksi', 'desc')
            // ->take(50)
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
        ))->unique()->sort()->reverse()->take(5); //ambil 5 data terakhir

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
        $settingPageId = $request->input('setting_page_id');
        $user = auth()->user();

        $applyScope = function ($query) use ($user, $settingPageId) {
            if ($user->isSuperAdmin()) {
                $query->withoutGlobalScope('setting_page');
                if ($settingPageId) {
                    $query->where('setting_page_id', $settingPageId);
                }
            }
            return $query;
        };

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
        $pemasukanData = $applyScope(RekeningRekapBKU::query())
            ->whereIn('jenis_bahan', [
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
        $pengeluaranData = $applyScope(RekeningRekapBKU::query())
            ->whereIn('jenis_bahan', [
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

        $anggarans = $applyScope(Anggaran::query())
            ->where('start_date', '>=', $startDate)
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
                // $days = max(1, $anggaran->start_date->diffInDays($anggaran->end_date) + 1); //$days skip sabtu & minggu
                $days = max(1, $this->getBusinessDays($anggaran->start_date, $anggaran->end_date));
                return ($anggaran->budget_porsi_8k + $anggaran->budget_porsi_10k
                    + $anggaran->budget_operasional + $anggaran->budget_sewa) * $days;
            });
            $anggaranData[$date] = $totalAnggaran;
        }

        $realisasi = $applyScope(RekeningRekapBKU::query())
            ->whereIn('jenis_bahan', [
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
        $porsiData = $applyScope(Anggaran::query())
            ->where('start_date', '>=', $startDate)
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

    private function getAnggaranRealisasiData($settingPageId = null)
    {
        $user = auth()->user();
        $startDate = now()->subDays(90);

        $applyScope = function ($query) use ($user, $settingPageId) {
            if ($user->isSuperAdmin()) {
                $query->withoutGlobalScope('setting_page');
                if ($settingPageId) {
                    $query->where('setting_page_id', $settingPageId);
                }
            }
            return $query;
        };

        // Group anggaran by week
        $anggaranWeekly = $applyScope(Anggaran::query())
            ->where('start_date', '>=', $startDate)
            ->get()
            ->groupBy(function ($item) {
                return $item->start_date->format('Y-W');
            })
            ->map(function ($group) {
                return $group->sum(function ($anggaran) {
                    // $days = $anggaran->start_date->diffInDays($anggaran->end_date) + 1; //$days skip sabtu & minggu
                    $days = $this->getBusinessDays($anggaran->start_date, $anggaran->end_date);
                    return ($anggaran->budget_porsi_8k + $anggaran->budget_porsi_10k
                        + $anggaran->budget_operasional + $anggaran->budget_sewa) * $days;
                });
            });

        // Group realisasi by week
        $realisasiWeekly = $applyScope(RekeningRekapBKU::query())
            ->whereIn('jenis_bahan', [
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

    private function getBusinessDays($startDate, $endDate)
    {
        $businessDays = 0;
        $current = $startDate->copy();

        while ($current <= $endDate) {
            // Check if not Saturday (6) or Sunday (0)
            if ($current->dayOfWeek !== 0 && $current->dayOfWeek !== 6) {
                $businessDays++;
            }
            $current->addDay();
        }

        return $businessDays;
    }

    public function rekonsiliasi(Request $request)
    {
        $settingPageId = $request->input('setting_page_id');
        $user = auth()->user();

        $settingPages = null;
        if ($user->isSuperAdmin()) {
            $settingPages = \App\Models\SettingPage::all();
        }

        $applyScope = function ($query) use ($user, $settingPageId) {
            if ($user->isSuperAdmin()) {
                $query->withoutGlobalScope('setting_page');
                if ($settingPageId) {
                    $query->where('setting_page_id', $settingPageId);
                }
            }
            return $query;
        };

        $rekeningKorans = $applyScope(RekeningKoranVa::query())
            ->with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $rekeningBKUs = $applyScope(RekeningRekapBKU::query())
            ->with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // ... rest of method remains same
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
                'status' => abs($selisih) < 0.01 ? 'Match' : 'No Match'
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
            'rekeningBKUs' => $rekeningBKUs,
            'settingPages' => $settingPages,
            'settingPageId' => $settingPageId
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
