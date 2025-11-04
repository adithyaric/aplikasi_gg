<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RencanaMenu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'periode',
    ];

    public function paketMenu()
    {
        return $this->belongsToMany(PaketMenu::class, 'rencana_paket')
            ->withPivot('porsi')
            ->withTimestamps();
    }
}
