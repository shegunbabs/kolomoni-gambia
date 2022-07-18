<?php


namespace App\Services\Sms;


use App\Models\User;
use Illuminate\Support\Facades\Facade;

/**
 * Class OTPFacade
 * @package App\Services\Sms
 * @method static generateOtp(User $user)
 * @method static verifyOtp(User $user, string $code)
 */


class OTPFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'OtpService';
    }
}
