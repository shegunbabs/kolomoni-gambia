<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'account_number' => $this->bankone_account_number,
            'available_balance' => $this->available_balance,
            'withdrawable_balance' => $this->withdrawable_balance,
            'ledger_balance' => $this->ledger_balance,
            'account_tier' => $this->account_tier,
        ];
    }
}
