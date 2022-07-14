<?php


namespace App\Services\Pipes;

use App\Models\User;
use Closure;
use Illuminate\Support\Str;

class CreateUserPipe
{

    public function handle($data, Closure $next) {

        $user = User::query()->create([
            'firstname' => Str::lower($data['firstname']),
            'lastname' => Str::lower($data['lastname']),
            'email' => Str::lower($data['email']),
            'phone' => $data['phone'],
            'tin' => $data['tin'],
            //'dob' => $data['dob'] ?? null,
            'status' => 1,
            'password' => bcrypt($data['password']),
            'email_verified_at' => now(),
        ]);

        $user->devices()->create([
            'serial' => $data['device_serial'],
            'fcm_token' => $data['fcm_token'],
            'pin' => encrypt($data['device_pin'])
        ]);

        $token = $user->createToken($data['device_serial'])->plainTextToken;

        $data['user'] = $user;
        $data['token'] = $token;

        unset(
            $data['firstname'], $data['lastname'], $data['email'],
            $data['phone'], $data['tin'], $data['password']
        );

        return $next($data);
    }
}
