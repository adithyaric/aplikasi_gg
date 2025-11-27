<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekeningRekapBKU extends Model
{
    use SoftDeletes;

    protected $table = 'rekening_rekap_bku';

    protected $fillable = [
        'tanggal_transaksi',
        'no_bukti',
        'link_bukti',
        'jenis_bahan',
        'nama_bahan',
        'kuantitas',
        'satuan',
        'supplier',
        'uraian',
        'debit',
        'kredit',
        'saldo',
        'bulan',
        'minggu',
        'transaction_id',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'debit' => 'decimal:2',
        'kredit' => 'decimal:2',
        'saldo' => 'decimal:2',
        'kuantitas' => 'integer',
        'bulan' => 'integer',
        'minggu' => 'integer',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
