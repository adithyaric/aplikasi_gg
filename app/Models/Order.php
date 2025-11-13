<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number',
        'supplier_id',
        'tanggal_po',
        'tanggal_penerimaan',
        'grand_total',
        'status', // draft, confirmed
    ];

    protected $casts = [
        'tanggal_po' => 'date',
        'tanggal_penerimaan' => 'date',
        'grand_total' => 'float',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function getPaidAmountAttribute()
    {
        return $this->transaction?->amount ?? 0;
    }

    public function getOutstandingBalanceAttribute()
    {
        return $this->grand_total - $this->paid_amount;
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->paid_amount == 0) return 'unpaid';
        if ($this->paid_amount >= $this->grand_total) return 'paid';
        return 'partial';
    }
}