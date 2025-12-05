<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_karyawan_id',
        'nama',
        'no_hp',
        'lahir_tempat',
        'lahir_tanggal',
        'alamat',
        'kelamin' //pria, wanita
    ];

    protected $casts = [
        'lahir_tanggal' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriKaryawan::class, 'kategori_karyawan_id');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    public function gajis()
    {
        return $this->hasMany(Gaji::class);
    }
}