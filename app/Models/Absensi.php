<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'status', // hadir, tidak_hadir
        'confirmed' //true, false
    ];

    protected $casts = [
        'tanggal' => 'date',
        'confirmed' => 'boolean',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}