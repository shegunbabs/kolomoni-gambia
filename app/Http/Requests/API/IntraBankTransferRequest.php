<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class IntraBankTransferRequest extends FormRequest
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
            'from_account' => 'required|exists:accounts,bankone_account_number',
            'to_account' => 'required|different:from_account|exists:accounts,bankone_account_number',
            'amount' => 'required|numeric',
            'narration' => 'sometimes|string',
        ];
    }
}
