<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToSettingPage
{
    protected static function bootBelongsToSettingPage()
    {
        // Auto-set setting_page_id on create
        static::creating(function (Model $model) {
            if (auth()->check() && !$model->setting_page_id) {
                $model->setting_page_id = auth()->user()->setting_page_id;
            }
        });

        // Global scope for queries
        static::addGlobalScope('setting_page', function (Builder $builder) {
            if (auth()->check() && !auth()->user()->isSuperAdmin()) {
                $builder->where('setting_page_id', auth()->user()->setting_page_id);
            }
        });
    }

    public function settingPage()
    {
        return $this->belongsTo(\App\Models\SettingPage::class);
    }
}
