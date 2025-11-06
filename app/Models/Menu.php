<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        // 'paket_menu_id',
        'nama',
    ];

    //TODO ganti ke Many to Many
    public function paketMenu()
    {
        return $this->belongsTo(PaketMenu::class);
    }

    public function bahanBakus()
    {
        return $this->belongsToMany(BahanBaku::class, 'bahan_baku_menu')
            ->withPivot(['berat_bersih', 'energi'])
            ->withTimestamps();
    }
}