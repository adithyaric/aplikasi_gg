<?php

namespace App\Models;

use App\Traits\BelongsToSettingPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    use BelongsToSettingPage;

    protected $fillable = [
        // 'paket_menu_id',
        'nama',
    ];

    public function paketMenus()
    {
        return $this->belongsToMany(PaketMenu::class, 'menu_paket_menu')
            ->withTimestamps();
    }

    // Template relationship (just which bahan bakus are in this menu)
    public function bahanBakus()
    {
        return $this->belongsToMany(BahanBaku::class, 'menu_bahan_baku')
            ->withTimestamps();
    }

    // Actual data with weight/energy for specific paket
    public function bahanBakusForPaket($paketMenuId)
    {
        return $this->belongsToMany(BahanBaku::class, 'bahan_baku_menu')
            ->wherePivot('paket_menu_id', $paketMenuId)
            ->withPivot(['paket_menu_id', 'berat_bersih', 'energi'])
            ->withTimestamps();
    }
}