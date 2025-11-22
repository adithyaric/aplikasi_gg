<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'bahan_baku_id',
        'bahan_operasional_id',
        'quantity',
        'quantity_diterima',
        'satuan',
        'unit_cost',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'float',
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
}