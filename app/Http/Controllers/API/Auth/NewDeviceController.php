<?php


namespace App\Http\Controllers\API\Auth;


use App\Helpers\ApiResponse;
use App\Http\Resources\UserAccountResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Sms\OTPFacade;
use Illuminate\Http\Request;

class NewDeviceController
{


    public function __invoke($device_serial, $user_id, Request $request)
    {
        $device = $device_serial;
        $uid = $user_id;
        $request->validate([
            'otp' => 'required|string|size:6',
            'fcm_token' => 'required|string',
        ]);

        $user = User::find($uid);
        $res = OTPFacade::verifyOtp($user, $request->otp);

        if (!$res) {
            return ApiResponse::failed('Invalid token supplied');
        }

        $user->devices()->create(['serial' => $device, 'fcm_token' => $request->fcm_token]);
        $out['user'] = new UserResource($user);
        $out['token'] = $user->createToken($device)->plainTextToken;
        $out['fcm_token'] = $request->fcm_token;
        $out['account'] = new UserAccountResource($user->account);
        return ApiResponse::success('Login Successful', $out);

    }
}
