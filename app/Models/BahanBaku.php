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

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'bahan_baku_menu')
            ->withPivot(['berat_bersih', 'energi'])
            ->withTimestamps();
    }

    public function gizi()
    {
        return $this->hasOne(Gizi::class);
    }
}
