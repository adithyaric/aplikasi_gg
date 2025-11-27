<?php

namespace App\Http\Controllers;

use App\Models\RekeningKoranVa;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekeningKoranVaController extends Controller
{
    public function index()
    {
        $rekeningKoran = RekeningKoranVa::with('transaction')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $title = 'Rekening Koran VA';
        dd($rekeningKoran?->toArray(), $title);
        return view('keuangan.rekening-koran-va.index', compact('rekeningKoran', 'title'));
    }

    public function create()
    {
        $lastSaldo = RekeningKoranVa::orderBy('tanggal_transaksi', 'desc')
            ->orderBy('id', 'desc')
            ->value('saldo') ?? 0;

        $transactions = Transaction::whereHas('order')
            ->whereDoesntHave('rekeningKoranVa')
            ->with('order')
            ->get();

        $title = 'Formulir Rekening Koran VA';
        // dd($lastSaldo, $transactions?->toArray());
        return view('keuangan.rekening-koran-va.create', compact('lastSaldo', 'transactions', 'title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'ref' => 'required|string',
            'uraian' => 'required|string',
            'debit' => 'required|numeric|min:0',
            'kredit' => 'required|numeric|min:0',
            'saldo' => 'required|numeric',
            'kategori_transaksi' => 'required|string',
            'minggu' => 'nullable|integer|min:1|max:4',
            'transaction_id' => 'nullable|exists:transactions,id',
        ]);

        DB::beginTransaction();
        try {
            $lastSaldo = RekeningKoranVa::orderBy('tanggal_transaksi', 'desc')
                ->orderBy('id', 'desc')
                ->value('saldo') ?? 0;

            $debit = floatval($validated['debit']);
            $kredit = floatval($validated['kredit']);

            $newSaldo = $lastSaldo - $debit + $kredit;

            $validated['saldo'] = $newSaldo;

            dd($validated);
            RekeningKoranVa::create($validated);

            DB::commit();
            return redirect()->route('rekening-koran-va.index')
                ->with('success', 'Data rekening koran berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }
}
