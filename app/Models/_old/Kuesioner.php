<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    use HasFactory;

    protected $table = 'kuesioner';
    protected $fillable = ['paket_id', 'pertanyaan', 'opsi_jawaban'];

    protected $casts = [
        'opsi_jawaban' => 'array',
    ];

    public function paket()
    {
        return $this->belongsTo(PaketSurvey::class, 'paket_id');
    }

    public function jawabanResponden()
    {
        return $this->hasMany(JawabanResponden::class, 'kuesioner_id');
    }
}
