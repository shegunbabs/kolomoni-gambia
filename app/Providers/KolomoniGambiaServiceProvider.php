<?php

namespace App\Providers;

use App\Services\BankOne\BankOneService;
use Illuminate\Support\ServiceProvider;

class KolomoniGambiaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('BankOne', fn($app) => new BankOneService());
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
