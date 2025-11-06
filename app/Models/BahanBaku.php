<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanBaku extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'kelompok',
        'jenis',
        'satuan',
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
}
