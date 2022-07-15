<?php


namespace App\Http\Controllers\API;


use App\Helpers\AccountHelper;
use App\Helpers\ApiResponse;
use App\Http\Resources\UserAccountResource;
use App\Models\User;
use App\Services\BankOne\BankOneFacade;
use Illuminate\Http\Request;

class BalanceEnquiry
{

    public function __invoke(Request $request)
    {

        $request->validate([
            'account_number' => 'required',
            //'email' => 'required|email'
        ]);

        $user = User::with('account')->where('email', $request->email)->first();

        if (! $user ) {
            return ApiResponse::failed('Invalid email');
        }

        if ( $user->account->bankone_account_number !== $request->account_number ) {
            return ApiResponse::failed('Invalid account number');
        }

        $response = BankOneFacade::getAccountByAccountNumber($user->account->account_number);

        if (! empty($response['AvailableBalance']) ) {
            AccountHelper::SyncAccountBalance($user, $response);
        }
        $out['account'] = new UserAccountResource($user->account);
        return ApiResponse::success('Account balance retrieved', $out);
    }
}
