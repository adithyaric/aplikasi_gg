<?php

namespace App\Providers;

use App\Models\SettingPage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale('id');

        \Carbon\Carbon::macro('formatId', function ($format = 'd/m/Y') {
            return $this->locale('id')->translatedFormat($format);
        });

        view()->share('settingView', SettingPage::find(auth()->user()?->setting_page_id) ?? []);
    }
}
