<?php

namespace App\Http\Controllers;

use App\Models\RekeningRekapBKU;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RekeningRekapBKUController extends Controller
{
    public function index()
    {
        $rekeningBKU = RekeningRekapBKU::with('transaction.order.supplier')
            ->orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $selisihFound = false;
        $selisihDetails = [];

        foreach ($rekeningBKU as $index => $item) {
            if ($index === 0) continue;

            $prevItem = $rekeningBKU[$index - 1];
            $expectedSaldo = $prevItem->saldo + $item->debit - $item->kredit;

            if (abs($expectedSaldo - $item->saldo) > 1) {
                $selisihFound = true;
                $selisihDetails[] = [
                    'entry' => $item,
                    'expected' => $expectedSaldo,
                    'actual' => $item->saldo,
                    'difference' => $item->saldo - $expectedSaldo,
                ];
            }
        }

        $title = 'Rekap BKU';

        return view('keuangan.rekening-rekap-bku.index', compact('rekeningBKU', 'title', 'selisihFound', 'selisihDetails'));
    }

    public function create()
    {
        $lastSaldo = RekeningRekapBKU::orderBy('tanggal_transaksi', 'desc')
            ->orderBy('id', 'desc')
            ->value('saldo') ?? 0;

        $transactions = Transaction::whereHas('order')
            ->whereDoesntHave('rekeningRekapBKU')
            ->with('order')
            ->get();

        $title = 'Formulir Rekap BKU';
        return view('keuangan.rekening-rekap-bku.create', compact('lastSaldo', 'transactions', 'title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'no_bukti' => 'nullable|string',
            'link_bukti' => 'nullable|file|max:10240',
            'jenis_bahan' => 'nullable|string',
            'nama_bahan' => 'nullable|string',
            'kuantitas' => 'nullable|integer|min:1',
            'satuan' => 'nullable|string',
            'supplier' => 'nullable|string',
            'uraian' => 'required|string',
            'debit' => 'required|numeric|min:0',
            'kredit' => 'required|numeric|min:0',
            'bulan' => 'nullable|integer|min:1|max:12',
            'minggu' => 'nullable|integer|min:1|max:4',
            'transaction_id' => 'nullable|exists:transactions,id',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('link_bukti')) {
                $validated['link_bukti'] = $request->file('link_bukti')->store('bukti_bku', 'public');
            }

            $lastEntry = RekeningRekapBKU::lockForUpdate()
                ->orderBy('tanggal_transaksi', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $lastSaldo = $lastEntry ? $lastEntry->saldo : 0;
            $debit = floatval($validated['debit']);
            $kredit = floatval($validated['kredit']);

            $newSaldo = $lastSaldo + $debit - $kredit;
            $validated['saldo'] = $newSaldo;

            RekeningRekapBKU::create($validated);

            DB::commit();
            return redirect()->route('rekening-rekap-bku.index')
                ->with('success', 'Data rekap BKU berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $rekeningBKU = RekeningRekapBKU::with('transaction.order')->findOrFail($id);

        $lastSaldo = RekeningRekapBKU::orderBy('tanggal_transaksi', 'desc')
            ->orderBy('id', 'desc')
            ->value('saldo') ?? 0;

        $transactions = Transaction::whereHas('order')
            ->whereDoesntHave('rekeningRekapBKU')
            ->orWhere('id', $rekeningBKU->transaction_id)
            ->with('order')
            ->get();

        $title = 'Edit Rekap BKU';
        return view('keuangan.rekening-rekap-bku.edit', compact('lastSaldo', 'rekeningBKU', 'transactions', 'title'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'no_bukti' => 'nullable|string',
            'link_bukti' => 'nullable|file|max:10240',
            'jenis_bahan' => 'nullable|string',
            'nama_bahan' => 'nullable|string',
            'kuantitas' => 'nullable|integer|min:1',
            'satuan' => 'nullable|string',
            'supplier' => 'nullable|string',
            'uraian' => 'required|string',
            'debit' => 'required|numeric|min:0',
            'kredit' => 'required|numeric|min:0',
            'bulan' => 'nullable|integer|min:1|max:12',
            'minggu' => 'nullable|integer|min:1|max:4',
            'transaction_id' => 'nullable|exists:transactions,id',
        ]);

        DB::beginTransaction();
        try {
            $rekeningBKU = RekeningRekapBKU::lockForUpdate()->findOrFail($id);

            if ($request->hasFile('link_bukti')) {
                if ($rekeningBKU->link_bukti) {
                    Storage::disk('public')->delete($rekeningBKU->link_bukti);
                }
                $validated['link_bukti'] = $request->file('link_bukti')->store('bukti_bku', 'public');
            }

            $prevEntry = RekeningRekapBKU::where('tanggal_transaksi', '<', $rekeningBKU->tanggal_transaksi)
                ->orWhere(function ($q) use ($rekeningBKU) {
                    $q->where('tanggal_transaksi', '=', $rekeningBKU->tanggal_transaksi)
                        ->where('id', '<', $rekeningBKU->id);
                })
                ->orderBy('tanggal_transaksi', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $prevSaldo = $prevEntry ? $prevEntry->saldo : 0;
            $debit = floatval($validated['debit']);
            $kredit = floatval($validated['kredit']);

            $newSaldo = $prevSaldo + $debit - $kredit;
            $validated['saldo'] = $newSaldo;

            $rekeningBKU->update($validated);

            $nextEntries = RekeningRekapBKU::where('tanggal_transaksi', '>', $rekeningBKU->tanggal_transaksi)
                ->orWhere(function ($q) use ($rekeningBKU) {
                    $q->where('tanggal_transaksi', '=', $rekeningBKU->tanggal_transaksi)
                        ->where('id', '>', $rekeningBKU->id);
                })
                ->orderBy('tanggal_transaksi', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            $currentSaldo = $newSaldo;
            foreach ($nextEntries as $entry) {
                $currentSaldo = $currentSaldo + $entry->debit - $entry->kredit;
                $entry->update(['saldo' => $currentSaldo]);
            }

            DB::commit();
            return redirect()->route('rekening-rekap-bku.index')
                ->with('success', 'Data rekap BKU berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(RekeningRekapBKU $rekening_rekap_bku)
    {
        DB::beginTransaction();
        try {
            if ($rekening_rekap_bku->transaction_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak dapat dihapus karena terhubung dengan transaksi PO',
                ], 422);
            }

            $deletedEntry = $rekening_rekap_bku;

            if ($deletedEntry->link_bukti) {
                Storage::disk('public')->delete($deletedEntry->link_bukti);
            }

            $prevEntry = RekeningRekapBKU::where('tanggal_transaksi', '<', $deletedEntry->tanggal_transaksi)
                ->orWhere(function ($q) use ($deletedEntry) {
                    $q->where('tanggal_transaksi', '=', $deletedEntry->tanggal_transaksi)
                        ->where('id', '<', $deletedEntry->id);
                })
                ->orderBy('tanggal_transaksi', 'desc')
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $baseSaldo = $prevEntry ? $prevEntry->saldo : 0;
            $deletedEntry->delete();

            $nextEntries = RekeningRekapBKU::where('tanggal_transaksi', '>', $deletedEntry->tanggal_transaksi)
                ->orWhere(function ($q) use ($deletedEntry) {
                    $q->where('tanggal_transaksi', '=', $deletedEntry->tanggal_transaksi)
                        ->where('id', '>', $deletedEntry->id);
                })
                ->orderBy('tanggal_transaksi', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            $currentSaldo = $baseSaldo;
            foreach ($nextEntries as $entry) {
                $currentSaldo = $currentSaldo + $entry->debit - $entry->kredit;
                $entry->update(['saldo' => $currentSaldo]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data rekap BKU berhasil dihapus dan saldo telah diperbarui',
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
