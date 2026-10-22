<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\View::addNamespace('telasDocente', resource_path('views/telasDocente'));
        \Illuminate\Support\Facades\View::addNamespace('telasDocentes', resource_path('views/telasDocente'));
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
