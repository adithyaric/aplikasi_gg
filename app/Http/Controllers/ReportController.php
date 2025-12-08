<?php

namespace App\Http\Controllers;

use App\Models\RekeningRekapBKU;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function rekapPorsi()
    {
        $title = 'Rekap Porsi';
        return view('report.rekap-porsi', ['title' => $title]);
    }

    public function rekapPenerimaanDana()
    {
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
        $title = 'LBBP';
        return view('report.lbbp', ['title' => $title]);
    }

    public function lbo()
    {
        $title = 'LBO';
        return view('report.lbo', ['title' => $title]);
    }

    public function lbs()
    {
        $title = 'LBS';
        return view('report.lbs', ['title' => $title]);
    }

    public function lra()
    {
        $title = 'LRA';
        return view('report.lra', ['title' => $title]);
    }
}