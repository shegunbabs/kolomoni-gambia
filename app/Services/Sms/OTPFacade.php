<?php


namespace App\Services\Sms;


use Illuminate\Support\Facades\Facade;

class OTPFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'OtpService';
    }
}
