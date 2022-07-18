<?php


namespace App\Http\Controllers\API\Auth;


use App\Models\User;
use App\Services\Sms\OTPFacade;
use Illuminate\Http\Request;

class NewDeviceController
{


    public function __invoke($device_serial, $user_id, Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'pin' => 'required'
        ]);

        $user = User::find($user_id);

        $res = OTPFacade::verifyOtp($user, $request->otp);

        if ( $res ) {
        }

    }
}
