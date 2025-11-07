<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'nama_pic',
        'nomor',
        'jarak',
        'alamat',
        'long',
        'lat',
        'porsi_8k',
        'porsi_10k',
    ];

    protected $casts = [
        'nomor' => 'integer',
        'porsi_8k' => 'integer',
        'porsi_10k' => 'integer',
    ];
}
