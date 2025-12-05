<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OrderItem extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'order_id',
        'bahan_baku_id',
        'bahan_operasional_id',
        'quantity',
        'quantity_diterima',
        'quantity_penggunaan',
        'penggunaan_input_type',
        'satuan',
        'unit_cost',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'float',
        'quantity_penggunaan' => 'float',
        'unit_cost' => 'float',
        'subtotal' => 'float',
        'quantity_diterima' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }

    public function bahanOperasional()
    {
        return $this->belongsTo(BahanOperasional::class, 'bahan_operasional_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'order_id',
                'bahan_baku_id',
                'bahan_operasional_id',
                'quantity',
                'quantity_diterima',
                'quantity_penggunaan',
                'penggunaan_input_type',
                'satuan',
                'unit_cost',
                'subtotal',
                'notes',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
