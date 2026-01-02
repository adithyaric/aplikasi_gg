<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingPage extends Model
{
    protected $fillable = [
        'nama_sppg',
        'yayasan',
        'kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'nama_sppi',
        'ahli_gizi',
        'akuntan_sppg',
        'asisten_lapangan',
        'active', //true, false
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
