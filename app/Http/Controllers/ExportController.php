<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use App\Models\Anggaran;
use App\Models\BahanBaku;
use App\Models\BahanOperasional;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RekeningKoranVa;
use App\Models\RekeningRekapBKU;
use App\Models\RencanaMenu;
use App\Models\Sekolah;
use App\Models\StockAdjustment;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;

class ExportController extends Controller
{
    public function exportRekapPorsi(Request $request)
    {
        $query = Anggaran::with('sekolah');

        // Filter by date range if provided
        if ($request->has('start_at') && $request->has('end_at')) {
            $startDate = Carbon::parse($request->start_at);
            $endDate = Carbon::parse($request->end_at);

            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            });
        }

        $anggarans = $query->get();
        $rekapData = [];

        foreach ($anggarans as $anggaran) {
            $currentDate = $anggaran->start_date->copy();
            $endDate = $anggaran->end_date->copy();

            while ($currentDate <= $endDate) {
                // If date filters are provided, skip dates outside the range
                if ($request->has('start_at') && $request->has('end_at')) {
                    $filterStart = Carbon::parse($request->start_at);
                    $filterEnd = Carbon::parse($request->end_at);

                    if ($currentDate->lt($filterStart) || $currentDate->gt($filterEnd)) {
                        $currentDate->addDay();
                        continue;
                    }
                }

                $rekapData[] = [
                    'tanggal' => $currentDate->format('d/m/Y'),
                    'rencana_total' => $anggaran->total_porsi,
                    'rencana_8k' => $anggaran->porsi_8k,
                    'rencana_10k' => $anggaran->porsi_10k,
                    'budget_8k' => $anggaran->budget_porsi_8k,
                    'budget_10k' => $anggaran->budget_porsi_10k,
                    'budget_operasional' => $anggaran->budget_operasional,
                    'budget_sewa' => $anggaran->budget_sewa,
                ];
                $currentDate->addDay();
            }
        }

        // Sort by date
        usort($rekapData, function ($a, $b) {
            $dateA = Carbon::createFromFormat('d/m/Y', $a['tanggal']);
            $dateB = Carbon::createFromFormat('d/m/Y', $b['tanggal']);
            return $dateA->gt($dateB) ? 1 : -1;
        });

        //* Export Excel *//
        return Excel::download(new class($rekapData) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths, \Maatwebsite\Excel\Concerns\WithStyles {
            private $rekapData;

            public function __construct($rekapData)
            {
                $this->rekapData = $rekapData;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.rekap-porsi', [
                    'rekapData' => $this->rekapData,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 20,
                ];
            }

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                return [];
            }
        }, 'REKAP_PORSI_' . date('Y-m-d_H-i-T') . '.xlsx');
    }

    public function exportRekapPenerimaanDana()
    {
        $data = RekeningKoranVa::where('kredit', '>', 0)
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $totalKredit = $data->sum('kredit');

        return Excel::download(new class($data, $totalKredit) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $data;
            private $totalKredit;

            public function __construct($data, $totalKredit)
            {
                $this->data = $data;
                $this->totalKredit = $totalKredit;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.rekap-penerimaan-dana', [
                    'data' => $this->data,
                    'totalKredit' => $this->totalKredit,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 25,
                    'C' => 50,
                    'D' => 25,
                ];
            }
        }, 'REKAP_PENERIMAAN_DANA_' . date('Y-m-d_H-i') . '.xlsx');
    }

    public function exportRekonsiliasi(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $queryKoran = RekeningKoranVa::with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'asc');

        $queryBKU = RekeningRekapBKU::with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'asc');

        if ($request->start_date && $request->end_date) {
            $queryKoran->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
            $queryBKU->whereBetween('tanggal_transaksi', [$request->start_date, $request->end_date]);
        }

        $rekeningKorans = $queryKoran->get();
        $rekeningBKUs = $queryBKU->get();

        // Group by date and calculate summaries
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

            $selisih = ($koran['total_kredit'] + $koran['total_debit']) - ($bku['total_debit'] + $bku['total_kredit']);

            $reconciliationData[] = [
                'no' => $no++,
                'tanggal' => \Carbon\Carbon::parse($date),
                'jml_rek' => $koran['count'],
                'nilai_rek' => ($koran['total_kredit'] + $koran['total_debit']),
                'jml_buku' => $bku['count'],
                'nilai_buku' => ($bku['total_debit'] + $bku['total_kredit']),
                'selisih' => $selisih,
                'status' => abs($selisih) < 0.01 ? 'Match' : 'No Match'
            ];
        }

        return Excel::download(new class($reconciliationData, $request->start_date, $request->end_date) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $reconciliationData;
            private $startDate;
            private $endDate;

            public function __construct($reconciliationData, $startDate, $endDate)
            {
                $this->reconciliationData = $reconciliationData;
                $this->startDate = $startDate;
                $this->endDate = $endDate;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.rekonsiliasi', [
                    'reconciliationData' => $this->reconciliationData,
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 25,
                    'E' => 20,
                    'F' => 25,
                    'G' => 20,
                    'H' => 20,
                ];
            }
        }, 'REKONSILIASI_' . date('Y-m-d_H-i') . '.xlsx');
    }

    public function exportSekolah()
    {
        $sekolahs = Sekolah::all();

        return Excel::download(new class($sekolahs) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $sekolahs;

            public function __construct($sekolahs)
            {
                $this->sekolahs = $sekolahs;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.sekolah', [
                    'sekolahs' => $this->sekolahs,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 30,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                ];
            }
        }, 'SEKOLAH_' . date('Y-m-d_H-i-T') . '.xlsx');
    }

    public function exportSupplier()
    {
        $suppliers = Supplier::all();

        return Excel::download(new class($suppliers) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $suppliers;

            public function __construct($suppliers)
            {
                $this->suppliers = $suppliers;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.supplier', [
                    'suppliers' => $this->suppliers,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 30,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 30,
                ];
            }
        }, 'SUPPLIER_' . date('Y-m-d_H-i-T') . '.xlsx');
    }

    public function exportRelawan()
    {
        $karyawans = Karyawan::with('kategori')->get();

        return Excel::download(new class($karyawans) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $karyawans;

            public function __construct($karyawans)
            {
                $this->karyawans = $karyawans;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.relawan', [
                    'karyawans' => $this->karyawans,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 20,
                    'C' => 25,
                    'D' => 20,
                    'E' => 30,
                    'F' => 20,
                    'G' => 40,
                ];
            }
        }, 'RELAWAN_' . date('Y-m-d_H-i-T') . '.xlsx');
    }

    public function exportAbsensi(Request $request, $tanggal)
    {
        $absensis = Absensi::with('karyawan.kategori')
            ->whereDate('tanggal', $tanggal)
            ->get();

        $hadir = $absensis->where('status', 'hadir')->count();
        $tidakHadir = $absensis->where('status', 'tidak_hadir')->count();

        return Excel::download(new class($absensis, $tanggal, $hadir, $tidakHadir) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $absensis;
            private $tanggal;
            private $hadir;
            private $tidakHadir;

            public function __construct($absensis, $tanggal, $hadir, $tidakHadir)
            {
                $this->absensis = $absensis;
                $this->tanggal = $tanggal;
                $this->hadir = $hadir;
                $this->tidakHadir = $tidakHadir;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.absensi', [
                    'absensis' => $this->absensis,
                    'tanggal' => $this->tanggal,
                    'hadir' => $this->hadir,
                    'tidakHadir' => $this->tidakHadir,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 25,
                    'C' => 20,
                    'D' => 20,
                ];
            }
        }, 'ABSENSI_' . Carbon::parse($tanggal)->format('Y-m-d') . '.xlsx');
    }

    public function exportGaji(Request $request, $tanggal_mulai, $tanggal_akhir)
    {
        $gajis = Gaji::with(['karyawan.kategori'])
            ->whereDate('tanggal_mulai', $tanggal_mulai)
            ->whereDate('tanggal_akhir', $tanggal_akhir)
            ->get();

        $totalKaryawan = $gajis->count();
        $totalGaji = $gajis->sum('total_gaji');
        $totalHadir = $gajis->sum('jumlah_hadir');

        return Excel::download(new class($gajis, $tanggal_mulai, $tanggal_akhir, $totalKaryawan, $totalGaji, $totalHadir) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $gajis;
            private $tanggal_mulai;
            private $tanggal_akhir;
            private $totalKaryawan;
            private $totalGaji;
            private $totalHadir;

            public function __construct($gajis, $tanggal_mulai, $tanggal_akhir, $totalKaryawan, $totalGaji, $totalHadir)
            {
                $this->gajis = $gajis;
                $this->tanggal_mulai = $tanggal_mulai;
                $this->tanggal_akhir = $tanggal_akhir;
                $this->totalKaryawan = $totalKaryawan;
                $this->totalGaji = $totalGaji;
                $this->totalHadir = $totalHadir;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.gaji', [
                    'gajis' => $this->gajis,
                    'tanggal_mulai' => $this->tanggal_mulai,
                    'tanggal_akhir' => $this->tanggal_akhir,
                    'totalKaryawan' => $this->totalKaryawan,
                    'totalGaji' => $this->totalGaji,
                    'totalHadir' => $this->totalHadir,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 25,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                ];
            }
        }, 'GAJI_' . Carbon::parse($tanggal_mulai)->format('Y-m-d') . '_' . Carbon::parse($tanggal_akhir)->format('Y-m-d') . '.xlsx');
    }

    public function exportStok()
    {
        $bahanBakuStok = BahanBaku::select(
            'bahan_bakus.id',
            'bahan_bakus.nama',
            'bahan_bakus.kategori',
            'bahan_bakus.merek',
            'bahan_bakus.satuan',
            'bahan_bakus.gov_price'
        )
            ->leftJoin('order_items', function ($join) {
                $join->on('bahan_bakus.id', '=', 'order_items.bahan_baku_id')
                    ->whereNull('order_items.deleted_at');
            })
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->whereNull('orders.deleted_at');
            })
            ->groupBy(
                'bahan_bakus.id',
                'bahan_bakus.nama',
                'bahan_bakus.kategori',
                'bahan_bakus.merek',
                'bahan_bakus.satuan',
                'bahan_bakus.gov_price'
            )
            ->get()
            ->map(function ($item) {
                return $this->calculateStockData($item, 'bahan_baku');
            });

        $bahanOperasionalStok = BahanOperasional::select(
            'bahan_operasionals.id',
            'bahan_operasionals.nama',
            'bahan_operasionals.kategori',
            'bahan_operasionals.merek',
            'bahan_operasionals.satuan',
            'bahan_operasionals.gov_price'
        )
            ->leftJoin('order_items', function ($join) {
                $join->on('bahan_operasionals.id', '=', 'order_items.bahan_operasional_id')
                    ->whereNull('order_items.deleted_at');
            })
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->whereNull('orders.deleted_at');
            })
            ->groupBy(
                'bahan_operasionals.id',
                'bahan_operasionals.nama',
                'bahan_operasionals.kategori',
                'bahan_operasionals.merek',
                'bahan_operasionals.satuan',
                'bahan_operasionals.gov_price'
            )
            ->get()
            ->map(function ($item) {
                return $this->calculateStockData($item, 'bahan_operasional');
            });

        $stok = $bahanBakuStok->merge($bahanOperasionalStok);

        return Excel::download(new class($stok) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $stok;

            public function __construct($stok)
            {
                $this->stok = $stok;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.stok', [
                    'stok' => $this->stok,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 30,
                    'C' => 20,
                    'D' => 20,
                    'E' => 10,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                ];
            }
        }, 'STOCK_' . date('Y-m-d_H-i') . '.xlsx');
    }

    public function exportKartuStok(Request $request)
    {
        $request->validate([
            'bahan_id' => 'required',
            'type' => 'required|in:bahan_baku,bahan_operasional',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $bahanId = $request->bahan_id;
        $type = $request->type;
        $columnName = $type === 'bahan_baku' ? 'bahan_baku_id' : 'bahan_operasional_id';

        $bahan = $type === 'bahan_baku'
            ? BahanBaku::find($bahanId)
            : BahanOperasional::find($bahanId);

        if (!$bahan) {
            abort(404, 'Bahan tidak ditemukan');
        }

        // Get transactions (same logic as getKartuData)
        $orderItemsReceived = OrderItem::with('order')
            ->whereHas('order', function ($query) use ($request) {
                $query->whereNull('deleted_at')
                    ->whereNotNull('tanggal_penerimaan');
                if ($request->start_date && $request->end_date) {
                    $query->whereBetween('tanggal_penerimaan', [$request->start_date, $request->end_date]);
                }
            })
            ->where($columnName, $bahanId)
            ->where('quantity_diterima', true)
            ->whereNull('deleted_at')
            ->get();

        $orderItemsUsed = OrderItem::with('order')
            ->whereHas('order', function ($query) use ($request) {
                $query->whereNull('deleted_at')
                    ->whereNotNull('tanggal_penggunaan')
                    ->where('status_penggunaan', 'confirmed');
                if ($request->start_date && $request->end_date) {
                    $query->whereBetween('tanggal_penggunaan', [$request->start_date, $request->end_date]);
                }
            })
            ->where($columnName, $bahanId)
            ->whereNotNull('quantity_penggunaan')
            ->whereNull('deleted_at')
            ->get();

        $adjustments = StockAdjustment::where($columnName, $bahanId)
            ->whereNull('deleted_at')
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                return $query->whereBetween('adjustment_date', [$request->start_date, $request->end_date]);
            })
            ->get();

        // Combine transactions
        $allTransactions = collect();
        foreach ($orderItemsReceived as $item) {
            $allTransactions->push([
                'date' => $item->order->tanggal_penerimaan,
                'type' => 'penerimaan',
                'data' => $item
            ]);
        }
        foreach ($orderItemsUsed as $item) {
            $allTransactions->push([
                'date' => $item->order->tanggal_penggunaan,
                'type' => 'penggunaan',
                'data' => $item
            ]);
        }
        foreach ($adjustments as $adj) {
            $allTransactions->push([
                'date' => $adj->adjustment_date,
                'type' => 'adjustment',
                'data' => $adj
            ]);
        }

        $allTransactions = $allTransactions->sortBy(function ($item) {
            return $item['date']->timestamp;
        });

        // Build kartu data
        $kartuData = [];
        $runningStock = 0;
        $lastKnownPrice = 0;

        foreach ($allTransactions as $transaction) {
            if ($transaction['type'] === 'penerimaan') {
                $item = $transaction['data'];
                $masuk = $item->quantity;
                $keluar = 0;
                $stokAkhir = $runningStock + $masuk;
                $lastKnownPrice = $item->unit_cost;
                $nilai = $stokAkhir * $lastKnownPrice;

                $kartuData[] = [
                    'tanggal' => $item->order->tanggal_penerimaan,
                    'stok_awal' => $runningStock,
                    'masuk' => $masuk,
                    'keluar' => $keluar,
                    'stok_akhir' => $stokAkhir,
                    'harga' => $lastKnownPrice,
                    'nilai' => $nilai,
                    'keterangan' => 'Penerimaan: ' . ($item->order->order_number ?? '')
                ];
                $runningStock = $stokAkhir;
            } elseif ($transaction['type'] === 'penggunaan') {
                $item = $transaction['data'];
                $keluar = $item->quantity_penggunaan;
                $stokAkhir = $runningStock - $keluar;
                $nilai = $stokAkhir * $lastKnownPrice;

                $kartuData[] = [
                    'tanggal' => $item->order->tanggal_penggunaan,
                    'stok_awal' => $runningStock,
                    'masuk' => 0,
                    'keluar' => $keluar,
                    'stok_akhir' => $stokAkhir,
                    'harga' => $lastKnownPrice,
                    'nilai' => $nilai,
                    'keterangan' => 'Penggunaan: ' . ($item->order->order_number ?? '') . ($item->notes ? ' - ' . $item->notes : '')
                ];
                $runningStock = $stokAkhir;
            } else {
                $adj = $transaction['data'];
                $masuk = $adj->quantity > 0 ? $adj->quantity : 0;
                $keluar = $adj->quantity < 0 ? abs($adj->quantity) : 0;
                $stokAkhir = $runningStock + $masuk - $keluar;
                $nilai = $stokAkhir * $lastKnownPrice;

                $kartuData[] = [
                    'tanggal' => $adj->adjustment_date,
                    'stok_awal' => $runningStock,
                    'masuk' => $masuk,
                    'keluar' => $keluar,
                    'stok_akhir' => $stokAkhir,
                    'harga' => $lastKnownPrice,
                    'nilai' => $nilai,
                    'keterangan' => 'Penyesuaian Stok: ' . ($adj->keterangan ?? '-')
                ];
                $runningStock = $stokAkhir;
            }
        }

        return Excel::download(new class($bahan, $kartuData, $request->start_date, $request->end_date) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $bahan;
            private $kartuData;
            private $startDate;
            private $endDate;

            public function __construct($bahan, $kartuData, $startDate, $endDate)
            {
                $this->bahan = $bahan;
                $this->kartuData = $kartuData;
                $this->startDate = $startDate;
                $this->endDate = $endDate;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.kartu-stok', [
                    'bahan' => $this->bahan,
                    'kartuData' => $this->kartuData,
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 30,
                ];
            }
        }, 'KARTU_STOK_' . str_replace(' ', '_', $bahan->nama) . '_' . date('Y-m-d_H-i') . '.xlsx');
    }

    public function exportOpnameStok(Request $request)
    {
        $request->validate([
            'adjustment_date' => 'required|date',
        ]);

        // Get current stock data (same as getOpnameData)
        $bahanBakuStok = BahanBaku::select(
            'bahan_bakus.id',
            'bahan_bakus.nama',
            'bahan_bakus.satuan'
        )
            ->leftJoin('order_items', function ($join) {
                $join->on('bahan_bakus.id', '=', 'order_items.bahan_baku_id')
                    ->whereNull('order_items.deleted_at');
            })
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->whereNull('orders.deleted_at');
            })
            ->groupBy('bahan_bakus.id', 'bahan_bakus.nama', 'bahan_bakus.satuan')
            ->get()
            ->map(function ($item) {
                return $this->calculateStockData($item, 'bahan_baku');
            })
            ->filter(function ($item) {
                return $item->qty > 0;
            });

        $bahanOperasionalStok = BahanOperasional::select(
            'bahan_operasionals.id',
            'bahan_operasionals.nama',
            'bahan_operasionals.satuan'
        )
            ->leftJoin('order_items', function ($join) {
                $join->on('bahan_operasionals.id', '=', 'order_items.bahan_operasional_id')
                    ->whereNull('order_items.deleted_at');
            })
            ->leftJoin('orders', function ($join) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->whereNull('orders.deleted_at');
            })
            ->groupBy('bahan_operasionals.id', 'bahan_operasionals.nama', 'bahan_operasionals.satuan')
            ->get()
            ->map(function ($item) {
                return $this->calculateStockData($item, 'bahan_operasional');
            })
            ->filter(function ($item) {
                return $item->qty > 0;
            });

        $stok = $bahanBakuStok->merge($bahanOperasionalStok);

        // Format for export
        $exportData = $stok->map(function ($item) {
            return [
                'nama' => $item->nama,
                'kode' => $item->id,
                'satuan' => $item->satuan,
                'stok_fisik' => $item->qty, // Same as stok di kartu since no physical count yet
                'stok_dikartu' => $item->qty,
                'selisih' => 0, // Default 0 since no adjustment yet
                'keterangan' => '-',
            ];
        });

        return Excel::download(new class($exportData, $request->adjustment_date) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $exportData;
            private $adjustmentDate;

            public function __construct($exportData, $adjustmentDate)
            {
                $this->exportData = $exportData;
                $this->adjustmentDate = $adjustmentDate;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.opname-stok', [
                    'adjustments' => $this->exportData,
                    'adjustmentDate' => $this->adjustmentDate,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 30,
                    'C' => 10,
                    'D' => 10,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 30,
                ];
            }
        }, 'STOCK_OPNAME_' . date('Y-m-d_H-i') . '.xlsx');
    }

    private function calculateCurrentStock($bahan, $type)
    {
        $columnName = $type === 'bahan_baku' ? 'bahan_baku_id' : 'bahan_operasional_id';

        $orderItemsReceived = OrderItem::whereHas('order', function ($query) {
            $query->whereNotNull('tanggal_penerimaan');
        })
            ->where($columnName, $bahan->id)
            ->where('quantity_diterima', true)
            ->sum('quantity');

        $orderItemsUsed = OrderItem::whereHas('order', function ($query) {
            $query->whereNotNull('tanggal_penggunaan')
                ->where('status_penggunaan', 'confirmed');
        })
            ->where($columnName, $bahan->id)
            ->sum('quantity_penggunaan');

        $adjustments = StockAdjustment::where($columnName, $bahan->id)
            ->sum('quantity');

        return $orderItemsReceived + $adjustments - $orderItemsUsed;
    }

    private function calculateStockData($item, $type)
    {
        $columnName = $type === 'bahan_baku' ? 'bahan_baku_id' : 'bahan_operasional_id';

        // Get received items
        $orderItemsReceived = OrderItem::whereHas('order', function ($query) {
            $query->whereNotNull('tanggal_penerimaan');
        })
            ->where($columnName, $item->id)
            ->where('quantity_diterima', true)
            ->get();

        // Get used items
        $orderItemsUsed = OrderItem::whereHas('order', function ($query) {
            $query->whereNotNull('tanggal_penggunaan')
                ->where('status_penggunaan', 'confirmed');
        })
            ->where($columnName, $item->id)
            ->whereNotNull('quantity_penggunaan')
            ->get();

        // Calculate totals
        $totalReceived = $orderItemsReceived->sum('quantity');
        $totalUsed = $orderItemsUsed->sum('quantity_penggunaan');

        // Get stock adjustments
        $adjustments = StockAdjustment::where($columnName, $item->id)->sum('quantity');

        // Total quantity = received + adjustments - used
        $totalQty = $totalReceived + $adjustments - $totalUsed;

        $lastPurchasePrice = $orderItemsReceived->sortByDesc('created_at')->first()?->unit_cost ?? 0;

        // Calculate average cost
        $totalPurchaseValue = $orderItemsReceived->sum(function ($item) {
            return $item->quantity * $item->unit_cost;
        });
        $avgCost = $orderItemsReceived->sum('quantity') > 0 ? $totalPurchaseValue / $orderItemsReceived->sum('quantity') : 0;

        // Get kategori value
        $kategori = '-';
        if ($type === 'bahan_baku') {
            $kategori = is_array($item->kategori) ? implode(', ', $item->kategori) : ($item->kategori ?? '-');
        } else {
            $kategori = is_array($item->kategori) ? implode(', ', $item->kategori) : ($item->kategori ?? '-');
        }

        return (object) [
            'id' => $item->id,
            // 'sku' => 'PRD-' . str_pad($item->id, 5, '0', STR_PAD_LEFT),
            'nama' => $item->nama,
            'kategori' => $kategori,
            'merek' => $item->merek ?? '-',
            'satuan' => $item->satuan ?? '-',
            'qty' => $totalQty,
            'last_purchase_price' => $lastPurchasePrice,
            'avg_cost' => $avgCost,
            'gov_price' => $item->gov_price ?? 0,
            'type' => $type,
        ];
    }

    public function exportPurchaseOrder($id)
    {
        $order = Order::with(['supplier', 'items.bahanBaku', 'items.bahanOperasional', 'transaction'])
            ->findOrFail($id);

        return Excel::download(new class($order) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $order;

            public function __construct($order)
            {
                $this->order = $order;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.purchase-order', [
                    'order' => $this->order,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 35,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 25,
                ];
            }
        }, 'PO_' . $order->id . '_' . date('Y-m-d_H-i T') . '.xlsx');
    }

    public function exportBKU(Request $request)
    {
        $query = RekeningRekapBKU::with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc');

        // Filter by date range if provided
        if ($request->has('start_at') && $request->has('end_at')) {
            $startDate = Carbon::parse($request->start_at);
            $endDate = Carbon::parse($request->end_at);

            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $rekeningBKU = $query->get();

        return Excel::download(new class($rekeningBKU, $request->start_at, $request->end_at) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $rekeningBKU;
            private $startDate;
            private $endDate;

            public function __construct($rekeningBKU, $startDate, $endDate)
            {
                $this->rekeningBKU = $rekeningBKU;
                $this->startDate = $startDate;
                $this->endDate = $endDate;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.bku', [
                    'rekeningBKU' => $this->rekeningBKU,
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 60,
                    'E' => 25,
                    'F' => 25,
                    'G' => 25,
                    'H' => 25,
                    'I' => 25,
                ];
            }
        }, 'BKU_' . date('Y-m-d_H-i') . '.xlsx');
    }

    public function exportLPDB(Request $request)
    {
        $request->validate([
            'start_month' => 'required|date_format:Y-m'
        ]);

        $start = \Carbon\Carbon::parse($request->start_month . '-01')->startOfMonth();
        $end = \Carbon\Carbon::parse($request->start_month . '-01')->endOfMonth();
        $monthName = $start->translatedFormat('F');

        // Get initial saldo
        $lastEntry = RekeningRekapBKU::where('tanggal_transaksi', '<', $start)
            ->orderBy('tanggal_transaksi', 'desc')
            ->orderBy('id', 'desc')
            ->first();
        $saldoAwal = $lastEntry ? $lastEntry->saldo : 0;

        // Get rekening data for the month
        $rekeningData = RekeningRekapBKU::whereBetween('tanggal_transaksi', [$start, $end])
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $data = [];
        $counter = 1;
        $currentSaldo = $saldoAwal;

        foreach ($rekeningData as $rekening) {
            $penerimaanDana = in_array($rekening->jenis_bahan, ['Penerimaan BGN', 'Penerimaan Yayasan', 'Penerimaan Pihak Lainnya'])
                ? $rekening->debit : 0;

            $bahanPangan = $rekening->jenis_bahan == 'Bahan Pokok' ? $rekening->kredit : 0;
            $operasional = $rekening->jenis_bahan == 'Bahan Operasional' ? $rekening->kredit : 0;
            $sewa = $rekening->jenis_bahan == 'Pembayaran Sewa' ? $rekening->kredit : 0;

            $totalPengeluaran = $bahanPangan + $operasional + $sewa;
            $saldoAkhir = $currentSaldo + $penerimaanDana - $totalPengeluaran;

            $data[] = [
                'no' => $counter,
                'tanggal' => $rekening->tanggal_transaksi->formatId('d F Y'),
                'saldo_awal' => $currentSaldo,
                'penerimaan_dana' => $penerimaanDana,
                'bahan_pangan' => $bahanPangan,
                'operasional' => $operasional,
                'sewa' => $sewa,
                'total' => $totalPengeluaran,
                'saldo_akhir' => $saldoAkhir,
            ];

            $currentSaldo = $saldoAkhir;
            $counter++;
        }

        return Excel::download(new class($data, $monthName) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $data;
            private $monthName;

            public function __construct($data, $monthName)
            {
                $this->data = $data;
                $this->monthName = $monthName;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.lpdb', [
                    'data' => $this->data,
                    'monthName' => $this->monthName,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 12,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 20,
                ];
            }
        }, 'LPDB_' . str_replace('-', '_', $request->start_month) . '.xlsx');
    }

    public function exportLBBP(Request $request)
    {
        $query = RekeningRekapBKU::whereHas('transaction')
            ->with(['transaction.order.items.bahanBaku'])
            ->where('jenis_bahan', 'Bahan Pokok')
            ->orderBy('tanggal_transaksi', 'asc');

        // Filter by date range if provided
        if ($request->has('start_at') && $request->has('end_at')) {
            $startDate = Carbon::parse($request->start_at)->startOfDay();
            $endDate = Carbon::parse($request->end_at)->endOfDay();

            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $data = $query->get()
            ->flatMap(function ($rekening) {
                $orderItems = $rekening->transaction->order->items ?? collect();

                return $orderItems->map(function ($item) use ($rekening) {
                    if ($item->bahanBaku) {
                        // Get historical gov_price based on tanggal_transaksi
                        $govPrice = Activity::where('subject_type', BahanBaku::class)
                            ->where('subject_id', $item->bahan_baku_id)
                            ->where('created_at', '<=', $rekening->tanggal_transaksi)
                            ->orderBy('created_at', 'desc')
                            ->first();

                        $historicalGovPrice = $govPrice ?
                            ($govPrice->properties['attributes']['gov_price'] ??
                                $item->bahanBaku->gov_price) :
                            $item->bahanBaku->gov_price;

                        return [
                            'tanggal' => $rekening->tanggal_transaksi,
                            'nama_bahan' => $item->bahanBaku->nama,
                            'kuantitas' => $item->quantity,
                            'satuan' => $item->satuan,
                            'harga_satuan' => $item->unit_cost,
                            'total' => $item->subtotal,
                            'supplier' => $rekening->supplier,
                            'gov_price' => $historicalGovPrice,
                            'rekening_id' => $rekening->id
                        ];
                    }
                    return null;
                })->filter();
            });

        return Excel::download(new class($data, $request->start_at, $request->end_at) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $data;
            private $startDate;
            private $endDate;

            public function __construct($data, $startDate, $endDate)
            {
                $this->data = $data;
                $this->startDate = $startDate;
                $this->endDate = $endDate;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.lbbp', [
                    'data' => $this->data,
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 20,
                    'C' => 25,
                    'D' => 20,
                    'E' => 10,
                    'F' => 20,
                    'G' => 20,
                    'H' => 25,
                    'I' => 25,
                ];
            }
        }, 'LBBP_' . date('Y-m-d_H-i') . '.xlsx');
    }

    public function exportLBO(Request $request)
    {
        $query = RekeningRekapBKU::where('jenis_bahan', 'Bahan Operasional')
            ->orderBy('tanggal_transaksi', 'asc');

        // Filter by date range if provided
        if ($request->has('start_at') && $request->has('end_at')) {
            $startDate = Carbon::parse($request->start_at)->startOfDay();
            $endDate = Carbon::parse($request->end_at)->endOfDay();

            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $data = $query->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal_transaksi,
                    'uraian' => $item->uraian,
                    'nominal' => $item->kredit,
                    'keterangan' => $item->transaction?->order?->order_number,
                    'rekening_id' => $item->id,
                ];
            });

        return Excel::download(new class($data, $request->start_at, $request->end_at) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $data;
            private $startDate;
            private $endDate;

            public function __construct($data, $startDate, $endDate)
            {
                $this->data = $data;
                $this->startDate = $startDate;
                $this->endDate = $endDate;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.lbo', [
                    'data' => $this->data,
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 20,
                    'C' => 50,
                    'D' => 20,
                    'E' => 25,
                ];
            }
        }, 'LBO_' . date('Y-m-d_H-i') . '.xlsx');
    }

    public function exportLBS(Request $request)
    {
        $query = Anggaran::query();

        // Filter by date range if provided
        if ($request->has('start_at') && $request->has('end_at')) {
            $startDate = Carbon::parse($request->start_at);
            $endDate = Carbon::parse($request->end_at);

            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q2) use ($startDate, $endDate) {
                        $q2->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            });
        }

        $anggarans = $query->get();
        $data = [];

        foreach ($anggarans as $anggaran) {
            $currentDate = $anggaran->start_date->copy();
            $endDate = $anggaran->end_date->copy();

            while ($currentDate <= $endDate) {
                // If date filters are provided, skip dates outside the range
                if ($request->has('start_at') && $request->has('end_at')) {
                    $filterStart = Carbon::parse($request->start_at);
                    $filterEnd = Carbon::parse($request->end_at);

                    if ($currentDate->lt($filterStart) || $currentDate->gt($filterEnd)) {
                        $currentDate->addDay();
                        continue;
                    }
                }

                $data[] = [
                    'tanggal' => $currentDate->copy(),
                    'date_sort' => $currentDate->format('Y-m-d'),
                    'jumlah_porsi' => $anggaran->total_porsi,
                    'uraian' => "Biaya Sewa tanggal " . $currentDate->translatedFormat('d F Y') .
                        " sebanyak " . $anggaran->total_porsi . " Porsi Penerima Manfaat",
                    'nominal' => $anggaran->budget_sewa,
                    'keterangan' => ucwords(str_replace('_', ' ', $anggaran->aturan_sewa)),
                    'rekening_id' => $anggaran->id
                ];

                $currentDate->addDay();
            }
        }

        // Sort by date
        usort($data, function ($a, $b) {
            return strcmp($a['date_sort'], $b['date_sort']);
        });

        return Excel::download(new class($data, $request->start_at, $request->end_at) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $data;
            private $startDate;
            private $endDate;

            public function __construct($data, $startDate, $endDate)
            {
                $this->data = $data;
                $this->startDate = $startDate;
                $this->endDate = $endDate;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.lbs', [
                    'data' => $this->data,
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 60,
                    'E' => 20,
                    'F' => 20,
                ];
            }
        }, 'LBS_' . date('Y-m-d_H-i') . '.xlsx');
    }

    public function exportLRA(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Collect admin inputs from request
        $adminInputs = $request->except(['start_date', 'end_date']);

        // Prepare data for export using passed values
        $exportData = [
            'penerimaanItems' => [
                [
                    'uraian' => 'Penerimaan dari BGN (Sisa dana Periode Sebelumnya)',
                    'anggaran' => $adminInputs['anggaran_sisa_dana'] ?? 0,
                    'realisasi' => $adminInputs['realisasi_sisa_dana'] ?? 0,
                ],
                [
                    'uraian' => 'Penerimaan dari BGN',
                    'anggaran' => $adminInputs['anggaran_bgn'] ?? 0,
                    'realisasi' => $adminInputs['realisasi_bgn'] ?? 0,
                ],
                [
                    'uraian' => 'Penerimaan dari Yayasan',
                    'anggaran' => $adminInputs['anggaran_yayasan'] ?? 0,
                    'realisasi' => $adminInputs['realisasi_yayasan'] ?? 0,
                ],
                [
                    'uraian' => 'Penerimaan dari Pihak Lainnya',
                    'anggaran' => $adminInputs['anggaran_pihak_lain'] ?? 0,
                    'realisasi' => $adminInputs['realisasi_pihak_lain'] ?? 0,
                ],
            ],
            'belanjaItems' => [
                [
                    'uraian' => 'Belanja Bahan Pangan',
                    'anggaran' => $adminInputs['anggaran_bahan_pangan'] ?? 0,
                    'realisasi' => $adminInputs['realisasi_bahan_pangan'] ?? 0,
                ],
                [
                    'uraian' => 'Belanja Operasional',
                    'anggaran' => $adminInputs['anggaran_operasional'] ?? 0,
                    'realisasi' => $adminInputs['realisasi_operasional'] ?? 0,
                ],
                [
                    'uraian' => 'Belanja Sewa',
                    'anggaran' => $adminInputs['anggaran_sewa'] ?? 0,
                    'realisasi' => $adminInputs['realisasi_sewa'] ?? 0,
                ],
            ]
        ];

        // Calculate totals
        $totalAnggaranPenerimaan = array_sum(array_column($exportData['penerimaanItems'], 'anggaran'));
        $totalRealisasiPenerimaan = array_sum(array_column($exportData['penerimaanItems'], 'realisasi'));
        $totalAnggaranBelanja = array_sum(array_column($exportData['belanjaItems'], 'anggaran'));
        $totalRealisasiBelanja = array_sum(array_column($exportData['belanjaItems'], 'realisasi'));

        return Excel::download(
            new class($exportData, $startDate, $endDate, $totalAnggaranPenerimaan, $totalRealisasiPenerimaan, $totalAnggaranBelanja, $totalRealisasiBelanja) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
                private $exportData;
                private $startDate;
                private $endDate;
                private $totalAnggaranPenerimaan;
                private $totalRealisasiPenerimaan;
                private $totalAnggaranBelanja;
                private $totalRealisasiBelanja;

                public function __construct($exportData, $startDate, $endDate, $totalAnggaranPenerimaan, $totalRealisasiPenerimaan, $totalAnggaranBelanja, $totalRealisasiBelanja)
                {
                    $this->exportData = $exportData;
                    $this->startDate = $startDate;
                    $this->endDate = $endDate;
                    $this->totalAnggaranPenerimaan = $totalAnggaranPenerimaan;
                    $this->totalRealisasiPenerimaan = $totalRealisasiPenerimaan;
                    $this->totalAnggaranBelanja = $totalAnggaranBelanja;
                    $this->totalRealisasiBelanja = $totalRealisasiBelanja;
                }

                public function view(): \Illuminate\Contracts\View\View
                {
                    return view('exports.lra', [
                        'penerimaanItems' => $this->exportData['penerimaanItems'],
                        'belanjaItems' => $this->exportData['belanjaItems'],
                        'startDate' => $this->startDate,
                        'endDate' => $this->endDate,
                        'totalAnggaranPenerimaan' => $this->totalAnggaranPenerimaan,
                        'totalRealisasiPenerimaan' => $this->totalRealisasiPenerimaan,
                        'totalAnggaranBelanja' => $this->totalAnggaranBelanja,
                        'totalRealisasiBelanja' => $this->totalRealisasiBelanja,
                    ]);
                }

                public function columnWidths(): array
                {
                    return [
                        'A' => 50,
                        'B' => 25,
                        'C' => 25,
                        'D' => 20,
                    ];
                }
            },
            ($startDate && $endDate)
                ? 'LRA_' . str_replace('-', '', $startDate) . '_' . str_replace('-', '', $endDate) . '.xlsx'
                : 'LRA_All.xlsx'
        );
    }

    public function exportRencanaMenu(Request $request)
    {
        $query = RencanaMenu::with(['paketMenu.menus.bahanBakus'])
            ->orderBy('start_date', 'asc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }

        $rencanaMenus = $query->get();

        $exportData = [];
        $rowNumber = 1;

        foreach ($rencanaMenus as $rencana) {
            foreach ($rencana->paketMenu as $paket) {
                $porsi = $paket->pivot->porsi ?? 0;

                foreach ($paket->menus as $menu) {
                    // Get bahan bakus with paket-specific data
                    $bahanBakus = DB::table('bahan_baku_menu')
                        ->join('bahan_bakus', 'bahan_baku_menu.bahan_baku_id', '=', 'bahan_bakus.id')
                        ->where('bahan_baku_menu.paket_menu_id', $paket->id)
                        ->where('bahan_baku_menu.menu_id', $menu->id)
                        ->select(
                            'bahan_bakus.id',
                            'bahan_bakus.nama',
                            'bahan_bakus.satuan',
                            'bahan_baku_menu.berat_bersih',
                            'bahan_baku_menu.energi'
                        )
                        ->get();

                    foreach ($bahanBakus as $index => $bahan) {
                        $beratPerPorsi = $bahan->berat_bersih . ' ' . ($bahan->satuan ?? 'gram');
                        // $totalKebutuhan = ($bahan->berat_bersih * $porsi) / 1000 . ' kg'; // Convert to kg if gram
                        $totalKebutuhan = ($bahan->berat_bersih * $porsi) . ' ' . ($bahan->satuan ?? 'gram'); // Convert to kg if gram

                        $exportData[] = [
                            'no' => $rowNumber,
                            'tanggal' => \Carbon\Carbon::parse($rencana->start_date)->translatedFormat('d F Y'),
                            'paket_menu' => $paket->nama,
                            'nama_menu' => $menu->nama,
                            'bahan_makanan' => $bahan->nama,
                            'berat_per_porsi' => $beratPerPorsi,
                            'jumlah_porsi' => $porsi,
                            'total_kebutuhan' => $totalKebutuhan,
                        ];

                        $rowNumber++;
                    }
                }
            }
        }

        return Excel::download(new class($exportData, $request->start_date, $request->end_date) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $exportData;
            private $startDate;
            private $endDate;

            public function __construct($exportData, $startDate, $endDate)
            {
                $this->exportData = $exportData;
                $this->startDate = $startDate;
                $this->endDate = $endDate;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.rencana-menu', [
                    'exportData' => $this->exportData,
                    'startDate' => $this->startDate,
                    'endDate' => $this->endDate,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 20,
                    'C' => 20,
                    'D' => 25,
                    'E' => 25,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                ];
            }
        }, 'REKAP_MENU_' . date('Y-m-d_H-i') . '.xlsx');
    }

    public function exportBAST($id)
    {
        $order = Order::with(['supplier', 'items.bahanBaku', 'items.bahanOperasional'])
            ->findOrFail($id);

        // Cast items to collection if it's an array
        $items = collect($order->items);

        $itemsData = $items->map(function ($item) {
            // Make sure $item is an object
            $item = (object) $item;

            $qtyPO = $item->quantity;
            $qtyDiterima = $item->quantity_diterima ? $item->quantity : '-';
            $keterangan = $item->quantity_diterima ? 'Sesuai' : 'Tidak Sesuai';

            return [
                'jenis_bahan' => $item->bahanBaku->nama ?? $item->bahanOperasional->nama ?? '-',
                'satuan' => $item->bahanBaku->satuan ?? $item->bahanOperasional->satuan ?? $item->satuan,
                'qty_po' => $qtyPO,
                'qty_diterima' => $qtyDiterima,
                'keterangan' => $keterangan,
            ];
        });

        return Excel::download(new class($order, $itemsData) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $order;
            private $itemsData;

            public function __construct($order, $itemsData)
            {
                $this->order = $order;
                $this->itemsData = $itemsData;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.bast', [
                    'order' => $this->order,
                    'itemsData' => $this->itemsData,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,
                    'B' => 30,
                    'C' => 20,
                    'D' => 20,
                    'E' => 20,
                    'F' => 30,
                ];
            }
        }, 'BAST_' . $order->id . '_' . date('Y-m-d_H-i') . '.xlsx');
    }

    public function exportRekeningKoranVA()
    {
        $rekeningKoran = RekeningKoranVa::with('transaction.order')
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return Excel::download(new class($rekeningKoran) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithColumnWidths {
            private $rekeningKoran;

            public function __construct($rekeningKoran)
            {
                $this->rekeningKoran = $rekeningKoran;
            }

            public function view(): \Illuminate\Contracts\View\View
            {
                return view('exports.rekening-koran-va', [
                    'rekeningKoran' => $this->rekeningKoran,
                ]);
            }

            public function columnWidths(): array
            {
                return [
                    'A' => 20,    // No
                    'B' => 20,   // Tanggal
                    'C' => 40,   // Uraian
                    'D' => 20,   // Ref
                    'E' => 20,   // Debit
                    'F' => 20,   // Kredit
                    'G' => 20,   // Saldo
                    'H' => 20,   // Kategori Transaksi
                    'I' => 20,   // Minggu
                    'J' => 20,   // Link PO
                ];
            }
        }, 'REKENING_KORAN_VA_' . date('Y-m-d_H-i') . '.xlsx');
    }
}
