<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanResponden extends Model
{
    use HasFactory;

    protected $table = 'jawaban_responden';
    protected $fillable = ['responden_id', 'kuesioner_id', 'jawaban'];

    public function responden()
    {
        return $this->belongsTo(Responden::class, 'responden_id');
    }

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class, 'kuesioner_id');
    }
}
