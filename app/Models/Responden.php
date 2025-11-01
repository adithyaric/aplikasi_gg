<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    use HasFactory;

    protected $table = 'responden';
    protected $fillable = [
        'paket_id',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'pendidikan',
        'pekerjaan',
        'jenis_layanan'
    ];

    public function paket()
    {
        return $this->belongsTo(PaketSurvey::class, 'paket_id');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanResponden::class, 'responden_id');
    }
}
