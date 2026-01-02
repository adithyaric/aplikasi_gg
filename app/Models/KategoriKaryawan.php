<?php

namespace App\Models;

use App\Traits\BelongsToSettingPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriKaryawan extends Model
{
    use SoftDeletes;
    use BelongsToSettingPage;

    protected $fillable = [
        'nama',
        'nominal_gaji'
    ];

    protected $casts = [
        'nominal_gaji' => 'integer',
    ];

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class, 'kategori_karyawan_id');
    }
}