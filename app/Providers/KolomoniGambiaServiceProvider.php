<?php

namespace App\Providers;

use App\Services\BankOne\BankOneService;
use App\Services\Sms\OtpService;
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
        $this->app->bind('OtpService', fn($app) => new OtpService());
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
