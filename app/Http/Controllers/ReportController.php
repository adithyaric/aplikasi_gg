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

        // Get date range from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query RekeningRekapBKU with optional date filter
        $query = RekeningRekapBKU::query();

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        }

        $rekeningData = $query->get();

        // Calculate totals for each jenis_bahan
        $totalPenerimaanBGN = $rekeningData->where('jenis_bahan', 'Penerimaan BGN')->sum('debit');
        $totalBahanPokok = $rekeningData->where('jenis_bahan', 'Bahan Pokok')->sum('kredit');
        $totalBahanOperasional = $rekeningData->where('jenis_bahan', 'Bahan Operasional')->sum('kredit');
        $totalPembayaranSewa = $rekeningData->where('jenis_bahan', 'Pembayaran Sewa')->sum('kredit');

        // Penerimaan items (static structure with dynamic values)
        $penerimaanItems = [
            [
                'uraian' => 'Penerimaan dari BGN (Sisa dana Periode Sebelumnya)',
                'anggaran' => 0, // Static for now
                'realisasi' => 0, // Static for now
            ],
            [
                'uraian' => 'Penerimaan dari BGN',
                'anggaran' => $totalPenerimaanBGN,
                'realisasi' => 0, // Static for now
            ],
            [
                'uraian' => 'Penerimaan dari Yayasan',
                'anggaran' => 0, // Static for now
                'realisasi' => 0, // Static for now
            ],
            [
                'uraian' => 'Penerimaan dari Pihak Lainnya',
                'anggaran' => 0, // Static for now
                'realisasi' => 0, // Static for now
            ],
        ];

        // Belanja items (dynamic from RekeningRekapBKU)
        $belanjaItems = [
            [
                'uraian' => 'Belanja Bahan Pangan',
                'anggaran' => $totalBahanPokok,
                'realisasi' => 0, // Static for now
            ],
            [
                'uraian' => 'Belanja Operasional',
                'anggaran' => $totalBahanOperasional,
                'realisasi' => 0, // Static for now
            ],
            [
                'uraian' => 'Belanja Sewa',
                'anggaran' => $totalPembayaranSewa,
                'realisasi' => 0, // Static for now
            ],
        ];

        return view('report.lra', [
            'title' => $title,
            'penerimaanItems' => $penerimaanItems,
            'belanjaItems' => $belanjaItems,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
