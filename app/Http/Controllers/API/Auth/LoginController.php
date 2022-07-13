<?php


namespace App\Http\Controllers\API\Auth;


use App\Helpers\ApiResponse;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController
{

    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_serial' => 'required',
        ]);

        $user = User::query()->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ( $user->devices()->where('serial', $request->device_serial)->first() ) {
            $token = $user->createToken($request->device_serial)->plainTextToken;
            $out['user'] = new UserResource($user);
            $out['token'] = $token;
            return ApiResponse::success('Login successful', $out);
        }

        //new device
        //send otp
        $out['device'] = ['This device needs to be registered'];
        return ApiResponse::failed('New device detected', $out, 'errors');
    }
}
