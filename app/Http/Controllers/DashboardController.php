<?php

namespace App\Http\Controllers;

use App\Models\RekeningKoranVa;
use App\Models\RekeningRekapBKU;
use App\Models\Sekolah;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard');
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
            $selisih = $koran['total_kredit'] - $bku['total_debit'];

            $reconciliationData[] = [
                'no' => $no++,
                'tanggal' => \Carbon\Carbon::parse($date)->translatedFormat('j F Y'),
                'jml_rek' => $koran['count'],
                'nilai_rek' => $koran['total_kredit'],
                'jml_buku' => $bku['count'],
                'nilai_buku' => $bku['total_debit'],
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
}
