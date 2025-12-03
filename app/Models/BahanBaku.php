<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BahanBaku extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'nama',
        'kelompok',
        'jenis',
        'kategori',
        'satuan',
        'merek',
        'gov_price',
        'ukuran',
    ];

    protected $casts = [
        'kategori' => 'array'
    ];

    // Template relationship (just which menus use this bahan baku)
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_bahan_baku')
            ->withTimestamps();
    }

    // Actual data with weight/energy for specific paket
    public function menusForPaket($paketMenuId)
    {
        return $this->belongsToMany(Menu::class, 'bahan_baku_menu')
            ->wherePivot('paket_menu_id', $paketMenuId)
            ->withPivot(['paket_menu_id', 'berat_bersih', 'energi'])
            ->withTimestamps();
    }

    public function gizi()
    {
        return $this->hasOne(Gizi::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
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
