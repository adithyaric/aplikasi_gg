<?php

namespace App\Models;

use App\Traits\BelongsToSettingPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RencanaMenu extends Model
{
    use SoftDeletes;
    use BelongsToSettingPage;

    protected $fillable = [
        'periode',
        'start_date',
        'end_date',
    ];

    public function paketMenu()
    {
        return $this->belongsToMany(PaketMenu::class, 'rencana_paket')
            ->withPivot('porsi')
            ->withTimestamps();
    }
}
