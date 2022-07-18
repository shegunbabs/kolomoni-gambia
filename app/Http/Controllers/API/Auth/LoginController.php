<?php


namespace App\Http\Controllers\API\Auth;


use App\Helpers\ApiResponse;
use App\Http\Resources\UserAccountResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController
{

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_serial' => 'required',
            'fcm_token' => 'required',
        ]);

        $user = User::query()->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ( $device = $user->devices()->where('serial', $request->device_serial)->first() ) {
            // update fcm_token
            tap($device)->update(['fcm_token' => $request->fcm_token]);
            // create the token
            $token = $user->createToken($request->device_serial)->plainTextToken;
            $out['user'] = new UserResource($user);
            $out['token'] = $token;
            $out['fcm_token'] = $request->fcm_token;
            $out['account'] = new UserAccountResource($user->account);
            return ApiResponse::success('Login successful', $out);
        }

        // new device
        // send email notification
        //
        $url = route('authorize.new-device', ['device_serial' => $request->device_serial, 'user_id' => $user->id]);

        $out['event_type'] = 'This device needs to be registered';
        $out['event_url'] = $url;
        return ApiResponse::success('New device detected', $out, 'data');
    }
}
