<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gaji extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'karyawan_id',
        'rekening_rekap_bku_id',
        'periode_bulan',
        'periode_tahun',
        'tanggal_mulai',
        'tanggal_akhir',
        'jumlah_hadir',
        'nominal_per_hari',
        'total_gaji',
        'status', // hold, confirm
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
        'jumlah_hadir' => 'integer',
        'nominal_per_hari' => 'integer',
        'total_gaji' => 'integer',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function rekeningRekapBKU()
    {
        return $this->belongsTo(RekeningRekapBKU::class);
    }

    protected static function booted()
    {
        static::updated(function ($gaji) {
            if ($gaji->isDirty('status') && $gaji->status === 'confirm' && !$gaji->rekening_rekap_bku_id) {
                DB::beginTransaction();
                try {
                    // Get previous entry for saldo calculation
                    $prevEntry = RekeningRekapBKU::orderBy('tanggal_transaksi', 'desc')
                        ->orderBy('id', 'desc')
                        ->lockForUpdate()
                        ->first();

                    $prevSaldo = $prevEntry ? $prevEntry->saldo : 0;
                    $kredit = $gaji->total_gaji;
                    $newSaldo = $prevSaldo - $kredit;

                    // Create BKU entry
                    $bku = RekeningRekapBKU::create([
                        'tanggal_transaksi' => now(),
                        'no_bukti' => null,
                        'link_bukti' => null,
                        'jenis_bahan' => 'Pembayaran Operasional',
                        'nama_bahan' => $gaji->karyawan->nama,
                        'kuantitas' => $gaji->jumlah_hadir,
                        'satuan' => 'hari',
                        'supplier' => null,
                        'uraian' => "Pembayaran Gaji {$gaji->karyawan->nama} - {$gaji->karyawan->kategori->nama} periode " .
                            \Carbon\Carbon::create($gaji->periode_tahun, $gaji->periode_bulan)->format('F Y') .
                            " ({$gaji->tanggal_mulai->format('d/m/Y')} - {$gaji->tanggal_akhir->format('d/m/Y')})",
                        'debit' => 0,
                        'kredit' => $kredit,
                        'saldo' => $newSaldo,
                        'bulan' => $gaji->periode_bulan,
                        'minggu' => null,
                        'transaction_id' => null,
                    ]);

                    // Update gaji with BKU reference
                    $gaji->rekening_rekap_bku_id = $bku->id;
                    $gaji->saveQuietly(); // Use saveQuietly to avoid triggering updated event again

                    // Recalculate all entries after this one
                    $nextEntries = RekeningRekapBKU::where('tanggal_transaksi', '>', $bku->tanggal_transaksi)
                        ->orWhere(function ($q) use ($bku) {
                            $q->where('tanggal_transaksi', '=', $bku->tanggal_transaksi)
                                ->where('id', '>', $bku->id);
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
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }
            }
        });
    }
}
