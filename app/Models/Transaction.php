<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'payment_date',
        'payment_method',
        'payment_reference',
        'status', //'paid', 'unpaid', 'partial'
        'amount',
        'bukti_transfer', //path storage
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}