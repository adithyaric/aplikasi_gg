<?php

namespace App\Models;

use App\Traits\BelongsToSettingPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    use BelongsToSettingPage;

    protected $fillable = [
        'nama',
        'no_hp',
        'bank_no_rek',
        'bank_nama',
        'alamat',
        'long',
        'lat',
        'products',
    ];

    protected $casts = [
        'long' => 'float',
        'lat' => 'float',
    ];
}
