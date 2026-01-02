<?php

namespace App\Models;

use App\Traits\BelongsToSettingPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use BelongsToSettingPage;

    protected $guarded = ['id'];

    // protected $fillable = [
    //     'name',
    // ];
}
