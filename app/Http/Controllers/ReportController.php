<?php

namespace App\Http\Controllers;

use App\Models\RekeningKoranVa;
use App\Models\RekeningRekapBKU;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function rekapPorsi()
    {
        //Anggaran
        $title = 'Rekap Porsi';
        return view('report.rekap-porsi', ['title' => $title]);
    }

    public function rekapPenerimaanDana()
    {
        // RekeningKoranVa jenis transaksi credit
        $title = 'Rekap Penerimaan Dana';
        return view('report.rekap-penerimaan-dana', ['title' => $title]);
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
        //ada aksi (otomatis) menjabarkan orderitem'nya dr transaksi
        //survey = gov price dari activiry log
        $title = 'LBBP';
        return view('report.lbbp', ['title' => $title]);
    }

    public function lbo()
    {
        //RekeningRekapBKU jenis_bahan = bahan operasional
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