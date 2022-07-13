<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'fullname' => "{$this->firstname} {$this->lastname}",
            'email' => $this->email,
            'phone' => $this->phone,
            'tin' => $this->tin,
            'status' => 'ACTIVE',
            'date_of_birth' => Carbon::make($this->dob)->format('d-m-Y'),
            'account' => [
                'account_number' => $this->account->bankone_account_number,
                'available_balance' => $this->account->available_balance,
                'withdrawable_balance' => $this->account->withdrawable_balance,
                'ledger_balance' => $this->account->ledger_balance,
            ]
        ];
    }
}
