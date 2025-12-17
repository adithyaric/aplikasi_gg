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
        'debit', //Pemasukan
        'kredit', //Pengeluaran
        'saldo',
        'bulan',
        'minggu',
        'transaction_id',
        'jenis_buku_pembantu',
        /** string :
        dana bahan baku,
        dana operasional,
        dana insentif fasilitas,
        pungutan/setoran ppn,
        pungutan/setoran pph21,
        pungutan/setoran pph22,
        pungutan/setoran pph23,
        pungutan/setoran pph pasal4 ayat2,
        biaya bahan baku,
        biaya operasional,
        biaya insentif fasilitas,
        **/
        'sumber_dana', //string : (Petty cash/cash in hand), kas di bank
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
