<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketSurvey extends Model
{
    use HasFactory;

    protected $table = 'paket_survey';
    protected $fillable = [
        'kategori_id',
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriSkm::class, 'kategori_id');
    }

    public function kuesioner()
    {
        return $this->hasMany(Kuesioner::class, 'paket_id');
    }

    public function responden()
    {
        return $this->hasMany(Responden::class, 'paket_id');
    }
}
