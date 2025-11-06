<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketMenu extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama',
    ];

    // //TODO ganti ke Many to Many
    // public function menus()
    // {
    //     return $this->hasMany(Menu::class);
    // }
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
