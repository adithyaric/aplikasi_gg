<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\RekeningKoranVa;
use App\Models\RekeningRekapBKU;
use Illuminate\Http\Request;

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
                    'realisasi_total' => 0, // Placeholder - you'll need actual realization data
                    'realisasi_10k' => 0,  // Placeholder
                    'realisasi_8k' => 0,   // Placeholder
                    'keterangan' => $anggaran->aturan_sewa,
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
        //RekeningRekapBKU jenis_bahan = bahan pokok
        //ada aksi (otomatis) menjabarkan orderitem'nya dr transaksi/order
        //survey = gov price dari activiry log
        $title = 'LBBP';
        return view('report.lbbp', ['title' => $title]);
    }

    public function lbo()
    {
        //RekeningRekapBKU jenis_bahan = bahan operasional
        //Tidak perlu dijabarkan transaksi/order
        $title = 'LBO';
        return view('report.lbo', ['title' => $title]);
    }

    public function lbs()
    {
        //Anggaran looping start_date - end_date data"nya (misal dari tgl 1 - 30 : looping data sebanyak 30x)
        //Biaya Sewa tanggal xxxx sebanyak xxxx Porsi Penerima Manfaat
        //Nominal : Budget Sewa (2k)
        //col ket hapus
        $title = 'LBS';
        return view('report.lbs', ['title' => $title]);
    }

    public function lra()
    {
        //1. Penerimaan
        //2. Belanja RekeningBKU jenis_bahan sesuai belanja...
        //   Belanja Sewa :
        $title = 'LRA';
        return view('report.lra', ['title' => $title]);
    }
}