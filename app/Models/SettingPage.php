<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingPage extends Model
{
    protected $fillable = [
        'nama_sppg',
        'kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'nama_sppi',
        'ahli_gizi',
        'akuntan_sppg',
        'asisten_lapangan',
    ];
}
