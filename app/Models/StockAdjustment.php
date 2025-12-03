<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StockAdjustment extends Model
{
    use SoftDeletes;
    // use LogsActivity;

    protected $fillable = [
        'adjustment_date',
        'bahan_baku_id',
        'bahan_operasional_id',
        'quantity',
        'keterangan',
    ];

    protected $casts = [
        'adjustment_date' => 'date',
        'quantity' => 'float',
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }

    public function bahanOperasional()
    {
        return $this->belongsTo(BahanOperasional::class, 'bahan_operasional_id');
    }

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults()
    //         ->logOnly([
    //             'adjustment_date',
    //             'bahan_baku_id',
    //             'bahan_operasional_id',
    //             'quantity',
    //             'keterangan',
    //         ])
    //         ->logOnlyDirty()
    //         ->dontSubmitEmptyLogs();
    // }
}
