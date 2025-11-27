<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RekeningKoranVa extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'tanggal_transaksi',
        'ref',
        'uraian',
        'debit',
        'kredit',
        'saldo',
        'kategori_transaksi',
        'minggu',
        'transaction_id',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'debit' => 'float',
        'kredit' => 'float',
        'saldo' => 'float',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'tanggal_transaksi',
                'ref',
                'uraian',
                'debit',
                'kredit',
                'saldo',
                'kategori_transaksi',
                'minggu',
                'transaction_id',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
