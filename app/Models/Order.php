<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'order_number',
        'supplier_id',
        'tanggal_po',
        'tanggal_penerimaan',
        'grand_total',
        'status', // draft, posted
        'status_penerimaan', // draft, confirmed
        'notes',
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
        return $this->grand_total - $this->transaction?->amount;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'order_number',
                'supplier_id',
                'tanggal_po',
                'tanggal_penerimaan',
                'grand_total',
                'status', // draft, posted
                'status_penerimaan', // draft, confirmed
                'notes',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
