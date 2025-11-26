<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BahanOperasional extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'nama',
        'kategori',
        'satuan',
        'merek',
        'gov_price',
    ];

    protected $casts = [
        'kategori' => 'array'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'gov_price',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
