<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanOperasional extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'kategori',
        'satuan',
        'merek',
    ];

    protected $casts = [
        'kategori' => 'array'
    ];
}
