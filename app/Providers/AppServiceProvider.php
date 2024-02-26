<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::composer('layouts.frontend', 'App\Http\ViewComposers\InjectPages');
        View::composer('*', 'App\Http\ViewComposers\StatusMessage');
        View::composer('*', 'App\Http\ViewComposers\GlobalVars');
        View::composer(['layouts.frontend', 'templates.*', 'partials.*'], 'App\Http\ViewComposers\GlobalContent');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
