<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\BahanBaku;
use App\Models\BahanOperasional;
use App\Models\RekeningKoranVa;
use App\Models\RekeningRekapBKU;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ReportController extends Controller
{
    public function rekapPorsi()
    {
        // Get all anggaran data with sekolah relationship
        $anggarans = Anggaran::with('sekolah')->get();

        // Transform data into daily format
        $rekapData = [];

        foreach ($anggarans as $anggaran) {
            $currentDate = $anggaran->start_date->copy();
            $endDate = $anggaran->end_date->copy();

            while ($currentDate <= $endDate) {
                // Skip weekends if needed (optional)
                // if (!$currentDate->isWeekend()) {
                $rekapData[] = [
                    'tanggal' => $currentDate->format('d/m/Y'),
                    'rencana_total' => $anggaran->total_porsi,
                    'rencana_10k' => $anggaran->porsi_10k,
                    'rencana_8k' => $anggaran->porsi_8k,
                    //kolom" realisasi diganti jadi anggaran
                    'realisasi_total' => 0,
                    'budget_8k' => $anggaran->budget_porsi_8k,
                    'budget_10k' => $anggaran->budget_porsi_10k,
                    'budget_operasional' => $anggaran->budget_operasional,
                    'budget_sewa' => $anggaran->budget_sewa,
                    'date_sort' => $currentDate->format('Y-m-d'),
                ];
                // }

                $currentDate->addDay();
            }
        }

        // Sort by date
        usort($rekapData, function ($a, $b) {
            return strcmp($a['date_sort'], $b['date_sort']);
        });

        // dd($rekapData);
        $title = 'Rekap Porsi';
        return view('report.rekap-porsi', compact('rekapData', 'title'));
    }

    public function rekapPenerimaanDana()
    {
        // RekeningKoranVa jenis transaksi credit
        $title = 'Rekap Penerimaan Dana';
        $data = RekeningKoranVa::where('kredit', '>', 0)
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        return view('report.rekap-penerimaan-dana', [
            'title' => $title,
            'rekeningKoranVa' => $data
        ]);
    }

    public function bku()
    {
        $rekeningBKU = RekeningRekapBKU::with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $title = 'BKU';

        return view('report.bku', compact('rekeningBKU', 'title'));
    }

    public function lpdb()
    {
        // RekeningBKU, filter range bulan"
        // Saldo awal : pemasukan/debit
        // penerimaan dana : pengeluaran/kredit
        // sewa ambil dari Anggaran by tanggal (jika ada yg lempat bulan contoh nov 28 - 3 des dan di lpdb tampil yg nov maka tgl 28-30 saja)
        $title = 'LPDB';
        return view('report.lpdb', ['title' => $title]);
    }

    public function lbbp()
    {
        $title = 'LBBP';

        $data = RekeningRekapBKU::whereHas('transaction')
            ->with(['transaction.order.items.bahanBaku'])
            ->where('jenis_bahan', 'bahan pokok')
            ->orderBy('tanggal_transaksi', 'asc')
            ->get()
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

        return view('report.lbbp', [
            'title' => $title,
            'data' => $data
        ]);
    }

    public function lbo()
    {
        $title = 'LBO';

        $data = RekeningRekapBKU::where('jenis_bahan', 'bahan operasional')
            ->orderBy('tanggal_transaksi', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => $item->tanggal_transaksi,
                    'uraian' => $item->uraian,
                    'nominal' => $item->kredit, // LBO uses kredit (outflow)
                    // 'keterangan' => '', // Empty as per dummy
                    'rekening_id' => $item->id,
                    'link_po' => $item->transaction?->order?->order_number,
                    'link_po_id' => $item->transaction?->order?->id,
                ];
            });

        return view('report.lbo', [
            'title' => $title,
            'data' => $data
        ]);
    }

    public function lbs(Request $request)
    {
        $title = 'LBS';

        // Get all anggaran data
        $anggarans = Anggaran::all();

        $data = [];

        foreach ($anggarans as $anggaran) {
            $currentDate = $anggaran->start_date->copy();
            $endDate = $anggaran->end_date->copy();

            while ($currentDate <= $endDate) {
                $data[] = [
                    'tanggal' => $currentDate->format('d F Y'),
                    'date_sort' => $currentDate->format('Y-m-d'),
                    'jumlah_porsi' => $anggaran->total_porsi,
                    'uraian' => "Biaya Sewa tanggal " . $currentDate->format('d F Y') .
                        " sebanyak " . $anggaran->total_porsi . " Porsi Penerima Manfaat",
                    'nominal' => $anggaran->budget_sewa,
                    'keterangan' => $anggaran->aturan_sewa,
                    'rekening_id' => $anggaran->id
                ];

                $currentDate->addDay();
            }
        }

        // Sort by date
        usort($data, function ($a, $b) {
            return strcmp($a['date_sort'], $b['date_sort']);
        });

        return view('report.lbs', [
            'title' => $title,
            'data' => $data
        ]);
    }

    public function lra(Request $request)
    {
        $title = 'LRA';

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Calculate totals based on date range
        $data = $this->calculateLraData($startDate, $endDate);

        // Get admin inputs from request
        $adminInputs = $request->only([
            'anggaran_sisa_dana',
            'realisasi_sisa_dana',
            'realisasi_bgn',
            'realisasi_yayasan',
            'realisasi_pihak_lain',
            'realisasi_bahan_pangan',
            'realisasi_operasional',
            'realisasi_sewa'
        ]);

        // Prepare data for JSON response or view
        $responseData = [
            'title' => $title,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'penerimaanItems' => [
                [
                    'uraian' => 'Penerimaan dari BGN (Sisa dana Periode Sebelumnya)',
                    'anggaran' => $adminInputs['anggaran_sisa_dana'] ?? 0,
                    'realisasi' => $adminInputs['realisasi_sisa_dana'] ?? 0,
                    'input_anggaran_name' => 'anggaran_sisa_dana',
                    'input_realisasi_name' => 'realisasi_sisa_dana'
                ],
                [
                    'uraian' => 'Penerimaan dari BGN',
                    'anggaran' => $data['totalPenerimaanBGN'],
                    'realisasi' => $adminInputs['realisasi_bgn'] ?? 0,
                    'input_realisasi_name' => 'realisasi_bgn'
                ],
                [
                    'uraian' => 'Penerimaan dari Yayasan',
                    'anggaran' => $data['totalPenerimaanYayasan'],
                    'realisasi' => $adminInputs['realisasi_yayasan'] ?? 0,
                    'input_realisasi_name' => 'realisasi_yayasan'
                ],
                [
                    'uraian' => 'Penerimaan dari Pihak Lainnya',
                    'anggaran' => $data['totalPenerimaanPihakLain'],
                    'realisasi' => $adminInputs['realisasi_pihak_lain'] ?? 0,
                    'input_realisasi_name' => 'realisasi_pihak_lain'
                ],
            ],
            'belanjaItems' => [
                [
                    'uraian' => 'Belanja Bahan Pangan',
                    'anggaran' => $data['totalBudgetBahanPangan'],
                    'realisasi' => $adminInputs['realisasi_bahan_pangan'] ?? $data['totalBahanPokok'],
                    'input_realisasi_name' => 'realisasi_bahan_pangan'
                ],
                [
                    'uraian' => 'Belanja Operasional',
                    'anggaran' => $data['totalBudgetOperasional'],
                    'realisasi' => $adminInputs['realisasi_operasional'] ?? $data['totalBahanOperasional'],
                    'input_realisasi_name' => 'realisasi_operasional'
                ],
                [
                    'uraian' => 'Belanja Sewa',
                    'anggaran' => $data['totalBudgetSewa'],
                    'realisasi' => $adminInputs['realisasi_sewa'] ?? 0,
                    'input_realisasi_name' => 'realisasi_sewa'
                ],
            ]
        ];

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json($responseData);
        }

        // For regular request, return view
        return view('report.lra', $responseData);
    }

    private function calculateLraData($startDate, $endDate)
    {
        // Query for rekening data
        $query = RekeningRekapBKU::query();
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }
        $rekeningData = $query->get();

        // Calculate totals
        $data = [
            'totalPenerimaanBGN' => $rekeningData->where('jenis_bahan', 'Penerimaan BGN')->sum('debit'),
            'totalPenerimaanYayasan' => $rekeningData->where('jenis_bahan', 'Penerimaan Yayasan')->sum('debit'),
            'totalPenerimaanPihakLain' => $rekeningData->where('jenis_bahan', 'Penerimaan Pihak Lainnya')->sum('debit'),
            'totalBahanPokok' => $rekeningData->where('jenis_bahan', 'Bahan Pokok')->sum('kredit'),
            'totalBahanOperasional' => $rekeningData->where('jenis_bahan', 'Bahan Operasional')->sum('kredit'),
        ];

        // Query for anggaran data
        $queryAnggaran = Anggaran::query();
        if ($startDate && $endDate) {
            $queryAnggaran->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($sub) use ($startDate, $endDate) {
                        $sub->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            });
        }

        $anggarans = $queryAnggaran->get();

        $data['totalBudgetBahanPangan'] = $anggarans->sum('budget_porsi_8k') + $anggarans->sum('budget_porsi_10k');
        $data['totalBudgetOperasional'] = $anggarans->sum('budget_operasional');
        $data['totalBudgetSewa'] = $anggarans->sum('budget_sewa');

        return $data;
    }
}
