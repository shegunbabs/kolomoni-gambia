<?php


namespace App\Services\Sms;


use App\Models\User;
use OTPHP\TOTP;

class OtpService
{

    public function generateOtp(User$user): string {
        $secret = $this->getUserSecret($user);
        $timestamp = time();
        return TOTP::create($secret)->at($timestamp);
    }


    public function verifyOtp(User $user, string $code): bool {
        $secret = $this->getUserSecret($user);
        $timestamp = time();
        return TOTP::create($secret)->verify($code, $timestamp);
    }


    private function getUserSecret(User $user): string {
        return base64_encode($user->password);
    }
}
