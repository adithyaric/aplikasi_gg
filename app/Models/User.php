<?php

namespace App\Models;

// use App\Traits\BelongsToSettingPage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // use BelongsToSettingPage;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'nrp',
        'role',
        'password',
        'ttd',
        'setting_page_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function settingPage() //dapur
    {
        return $this->belongsTo(SettingPage::class);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }
}
