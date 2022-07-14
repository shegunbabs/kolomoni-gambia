<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstname' => ['required', 'alpha', 'min:3', 'max:20'],
            'lastname' => ['required', 'alpha', 'min:3', 'max:20'],
            'email' => ['required', 'email:rfc,dns', 'unique:users'],
            'phone' => ['required', 'string', 'min:7', 'max:11', 'unique:users',],
            'tin' => ['required', 'unique:users', 'digits:11'],
            //'dob' => ['required'],
            'password' => ['required', 'confirmed', 'string', 'min:6'],
            'device_serial' => ['required'],
            'device_pin' => ['required', 'string', 'min:4', 'max:6'],
        ];
    }
}
