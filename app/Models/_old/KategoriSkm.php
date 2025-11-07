<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSkm extends Model
{
    use HasFactory;

    protected $table = 'kategori_skm';
    protected $fillable = ['nama', 'deskripsi'];

    public function paketSurveys()
    {
        return $this->hasMany(PaketSurvey::class, 'kategori_id');
    }
}
