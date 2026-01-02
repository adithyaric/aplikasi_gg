<?php

namespace App\Models;

use App\Traits\BelongsToSettingPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketMenu extends Model
{
    use SoftDeletes;
    use BelongsToSettingPage;

    protected $fillable = [
        'nama',
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_paket_menu')
            ->withTimestamps();
    }

    public function rencanaMenu()
    {
        return $this->belongsToMany(rencanaMenu::class, 'rencana_paket')
            ->withPivot('porsi')
            ->withTimestamps();
    }
}
