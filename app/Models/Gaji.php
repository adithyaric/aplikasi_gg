<?php

namespace App\Models;

use App\Traits\BelongsToSettingPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gaji extends Model
{
    use SoftDeletes;
    use BelongsToSettingPage;

    protected $fillable = [
        'karyawan_id',
        'rekening_rekap_bku_id',
        'periode',
        'periode_minggu',
        'periode_bulan',
        'periode_tahun',
        'tanggal_mulai',
        'tanggal_akhir',
        'jumlah_hadir',
        'nominal_per_hari',
        'total_gaji',
        'status', // hold, confirm
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
        'jumlah_hadir' => 'integer',
        'nominal_per_hari' => 'integer',
        'total_gaji' => 'integer',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function rekeningRekapBKU()
    {
        return $this->belongsTo(RekeningRekapBKU::class);
    }
}
