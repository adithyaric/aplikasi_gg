<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use App\Models\Anggaran;
use App\Models\BahanBaku;
use App\Models\BahanOperasional;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\OrderItem;
use App\Models\RekeningKoranVa;
use App\Models\Sekolah;
use App\Models\StockAdjustment;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
                    'A' => 15,
                    'B' => 20,
                    'C' => 15,
                    'D' => 15,
                    'E' => 15,
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
                    'A' => 5,
                    'B' => 25,
                    'C' => 50,
                    'D' => 25,
                ];
            }
        }, 'REKAP_PENERIMAAN_DANA_' . date('Y-m-d_H-i') . '.xlsx');
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
                    'A' => 15,
                    'B' => 30,
                    'C' => 20,
                    'D' => 15,
                    'E' => 15,
                    'F' => 15,
                    'G' => 15,
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
                    'A' => 15,
                    'B' => 30,
                    'C' => 15,
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
                    'A' => 15,
                    'B' => 15,
                    'C' => 25,
                    'D' => 15,
                    'E' => 30,
                    'F' => 15,
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
                    'A' => 15,
                    'B' => 25,
                    'C' => 15,
                    'D' => 15,
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
                    'A' => 15,
                    'B' => 25,
                    'C' => 15,
                    'D' => 15,
                    'E' => 15,
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
                    'A' => 15,
                    'B' => 30,
                    'C' => 20,
                    'D' => 15,
                    'E' => 10,
                    'F' => 15,
                    'G' => 15,
                    'H' => 15,
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
                    'A' => 15,
                    'B' => 15,
                    'C' => 15,
                    'D' => 15,
                    'E' => 15,
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
                    'A' => 15,
                    'B' => 30,
                    'C' => 10,
                    'D' => 10,
                    'E' => 15,
                    'F' => 15,
                    'G' => 15,
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
}
