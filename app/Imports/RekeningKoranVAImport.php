<?php

namespace App\Imports;

use App\Models\RekeningKoranVa;
use App\Models\Transaction;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekeningKoranVAImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            // Get all existing entries ordered for saldo calculation
            $existingEntries = RekeningKoranVa::orderBy('tanggal_transaksi', 'asc')
                ->orderBy('id', 'asc')
                ->get();

            // Clear existing data if needed (optional)
            // RekeningKoranVa::truncate();

            $importedEntries = [];

            foreach ($rows as $row) {
                // Prepare data with proper null handling
                $tanggalTransaksi = isset($row['tanggal_transaksi']) ?
                    Carbon::parse($row['tanggal_transaksi']) : null;

                $transactionId = null;
                if (isset($row['transaction_id']) && !empty($row['transaction_id'])) {
                    $transaction = Transaction::find($row['transaction_id']);
                    $transactionId = $transaction ? $transaction->id : null;
                }

                $importedEntries[] = [
                    'tanggal_transaksi' => $tanggalTransaksi,
                    'ref' => $row['ref'] ?? null,
                    'uraian' => $row['uraian'] ?? null,
                    'debit' => floatval($row['debit'] ?? 0),
                    'kredit' => floatval($row['kredit'] ?? 0),
                    'kategori_transaksi' => $row['kategori_transaksi'] ?? null,
                    'minggu' => isset($row['minggu']) ? intval($row['minggu']) : null,
                    'transaction_id' => $transactionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Sort imported entries by tanggal_transaksi (and potentially time)
            usort($importedEntries, function ($a, $b) {
                if ($a['tanggal_transaksi'] == $b['tanggal_transaksi']) {
                    return 0;
                }
                return ($a['tanggal_transaksi'] < $b['tanggal_transaksi']) ? -1 : 1;
            });

            // Calculate saldo
            $currentSaldo = 0;
            foreach ($importedEntries as &$entry) {
                $currentSaldo = $currentSaldo - $entry['debit'] + $entry['kredit'];
                $entry['saldo'] = $currentSaldo;
            }

            // Insert all entries
            RekeningKoranVa::insert($importedEntries);

            // Recalculate all entries to ensure consistency
            $this->recalculateAllSaldos();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function recalculateAllSaldos()
    {
        $allEntries = RekeningKoranVa::orderBy('tanggal_transaksi', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $currentSaldo = 0;
        foreach ($allEntries as $entry) {
            $currentSaldo = $currentSaldo - $entry->debit + $entry->kredit;
            if (abs($entry->saldo - $currentSaldo) > 0.01) { // Allow 0.01 rounding difference
                $entry->update(['saldo' => $currentSaldo]);
            }
        }
    }
}
