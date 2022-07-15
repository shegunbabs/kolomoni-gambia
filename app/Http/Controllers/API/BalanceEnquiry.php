<?php


namespace App\Http\Controllers\API;


use App\Helpers\AccountHelper;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Services\BankOne\BankOneFacade;
use Illuminate\Http\Request;

class BalanceEnquiry
{

    public function __invoke(Request $request)
    {

        $request->validate([
            'account_number' => 'required',
            'email' => 'required|email'
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
            //get account balance
            $available_bal = $response['AvailableBalance'];
            $ledger_bal = $response['LedgerBalance'];
            $withdrawable_bal = $response['WithdrawableBalance'];


            //return synced account balance
            //AsyncAccountBalance($user->account->account_number);

            AccountHelper::SyncAccountBalance($response);

        }


    }
}
