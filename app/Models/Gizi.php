<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gizi extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'bahan_baku_id',
        'nomor_pangan',
        // 'rincian_bahan_makanan',
        'bdd',
        'air',
        'energi',
        'protein',
        'lemak',
        'karbohidrat',
        'serat',
        'abu',
        'kalsium',
        'fosfor',
        'koles',
        'besi',
        'natrium',
        'kalium',
        'tembaga',
        'retinol',
        'b_kar',
        'kar_total',
        'thiamin',
        'riboflavin',
        'niasin',
        'vitamin_c',
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }
}
