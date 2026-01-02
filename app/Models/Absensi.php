<?php

namespace App\Models;

use App\Traits\BelongsToSettingPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use SoftDeletes;
    use BelongsToSettingPage;

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