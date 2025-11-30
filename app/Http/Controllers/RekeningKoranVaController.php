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
        $rekeningKoran = RekeningKoranVa::with('transaction.order.supplier')->orderBy('tanggal_transaksi', 'asc')->orderBy('id', 'asc')->get();

        // Simple saldo discrepancy check
        $selisihFound = false;
        $selisihDetails = [];

        foreach ($rekeningKoran as $index => $item) {
            if ($index === 0) {
                continue;
            }

            $prevItem = $rekeningKoran[$index - 1];
            $expectedSaldo = $prevItem->saldo - $item->debit + $item->kredit;

            if (abs($expectedSaldo - $item->saldo) > 1) {
                // Allow 1 rupiah rounding difference
                $selisihFound = true;
                $selisihDetails[] = [
                    'entry' => $item,
                    'expected' => $expectedSaldo,
                    'actual' => $item->saldo,
                    'difference' => $item->saldo - $expectedSaldo,
                ];
            }
        }

        $title = 'Rekening Koran VA';

        return view('keuangan.rekening-koran-va.index', compact('rekeningKoran', 'title', 'selisihFound', 'selisihDetails'));
    }

    public function create()
    {
        $lastSaldo = RekeningKoranVa::orderBy('tanggal_transaksi', 'desc')->orderBy('id', 'desc')->value('saldo') ?? 0;

        $transactions = Transaction::whereHas('order')->whereDoesntHave('rekeningKoranVa')->with('order')->get();

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
            // Prevent race condition - lock the last record
            $lastEntry = RekeningKoranVa::lockForUpdate()->orderBy('tanggal_transaksi', 'desc')->orderBy('id', 'desc')->first();

            $lastSaldo = $lastEntry ? $lastEntry->saldo : 0;

            $debit = floatval($validated['debit']);
            $kredit = floatval($validated['kredit']);

            $newSaldo = $lastSaldo - $debit + $kredit;

            $validated['saldo'] = $newSaldo;

            // dd($validated);
            RekeningKoranVa::create($validated);

            DB::commit();
            return redirect()->route('rekening-koran-va.index')->with('success', 'Data rekening koran berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $rekeningKoran = RekeningKoranVa::with('transaction.order')->findOrFail($id);

        $transactions = Transaction::whereHas('order')->whereDoesntHave('rekeningKoranVa')->orWhere('id', $rekeningKoran->transaction_id)->with('order')->get();

        $title = 'Edit Rekening Koran VA';

        return view('keuangan.rekening-koran-va.edit', compact('rekeningKoran', 'transactions', 'title'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'ref' => 'required|string',
            'uraian' => 'required|string',
            'debit' => 'required|numeric|min:0',
            'kredit' => 'required|numeric|min:0',
            'kategori_transaksi' => 'required|string',
            'minggu' => 'nullable|integer|min:1|max:4',
            'transaction_id' => 'nullable|exists:transactions,id',
        ]);

        DB::beginTransaction();
        try {
            $rekeningKoran = RekeningKoranVa::lockForUpdate()->findOrFail($id);

            // Get previous entry
            $prevEntry = RekeningKoranVa::where('tanggal_transaksi', '<', $rekeningKoran->tanggal_transaksi)
                ->orWhere(function ($q) use ($rekeningKoran) {
                    $q->where('tanggal_transaksi', '=', $rekeningKoran->tanggal_transaksi)->where('id', '<', $rekeningKoran->id);
                })
                ->orderBy('tanggal_transaksi', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $prevSaldo = $prevEntry ? $prevEntry->saldo : 0;
            $debit = floatval($validated['debit']);
            $kredit = floatval($validated['kredit']);
            $newSaldo = $prevSaldo - $debit + $kredit;

            $validated['saldo'] = $newSaldo;
            $rekeningKoran->update($validated);

            // Recalculate all subsequent entries
            $nextEntries = RekeningKoranVa::where('tanggal_transaksi', '>', $rekeningKoran->tanggal_transaksi)
                ->orWhere(function ($q) use ($rekeningKoran) {
                    $q->where('tanggal_transaksi', '=', $rekeningKoran->tanggal_transaksi)->where('id', '>', $rekeningKoran->id);
                })
                ->orderBy('tanggal_transaksi', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            //TODO jadikan validasi di function lain
            $currentSaldo = $newSaldo;
            foreach ($nextEntries as $entry) {
                $currentSaldo = $currentSaldo - $entry->debit + $entry->kredit;
                $entry->update(['saldo' => $currentSaldo]);
            }

            DB::commit();
            return redirect()->route('rekening-koran-va.index')->with('success', 'Data rekening koran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(RekeningKoranVa $rekening_koran_va)
    {
        DB::beginTransaction();
        try {
            // Check if record is linked to a transaction
            if ($rekening_koran_va->transaction_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak dapat dihapus karena terhubung dengan transaksi PO',
                ], 422);
            }

            // Get the entry to be deleted
            $deletedEntry = $rekening_koran_va;

            // Get previous entry to determine base saldo
            $prevEntry = RekeningKoranVa::where('tanggal_transaksi', '<', $deletedEntry->tanggal_transaksi)
                ->orWhere(function ($q) use ($deletedEntry) {
                    $q->where('tanggal_transaksi', '=', $deletedEntry->tanggal_transaksi)
                        ->where('id', '<', $deletedEntry->id);
                })
                ->orderBy('tanggal_transaksi', 'desc')
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $baseSaldo = $prevEntry ? $prevEntry->saldo : 0;

            // Delete the entry
            $deletedEntry->delete();

            // Recalculate all subsequent entries
            $nextEntries = RekeningKoranVa::where('tanggal_transaksi', '>', $deletedEntry->tanggal_transaksi)
                ->orWhere(function ($q) use ($deletedEntry) {
                    $q->where('tanggal_transaksi', '=', $deletedEntry->tanggal_transaksi)
                        ->where('id', '>', $deletedEntry->id);
                })
                ->orderBy('tanggal_transaksi', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            $currentSaldo = $baseSaldo;
            foreach ($nextEntries as $entry) {
                $currentSaldo = $currentSaldo - $entry->debit + $entry->kredit;
                $entry->update(['saldo' => $currentSaldo]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data rekening koran berhasil dihapus dan saldo telah diperbarui',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
