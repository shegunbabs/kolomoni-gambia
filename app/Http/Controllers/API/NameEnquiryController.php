<?php


namespace App\Http\Controllers\API;


use App\Helpers\ApiResponse;
use App\Models\Account;
use App\Services\BankOne\BankOneFacade;
use Illuminate\Http\Request;

class NameEnquiryController
{

    public function __invoke(Request $request) {
        $request->validate([
            'account_number' => 'required',
        ]);
        $account = Account::query()->where('bankone_account_number', $request->account_number)->first();

        if ( $account ) {
            $enquiry = BankOneFacade::doNameEnquiry($account->account_number);
            $out['name'] = $enquiry['Name'];
            $out['account_number'] = $request->account_number;
            return ApiResponse::success('Account name retrieved', $out);
        }
        return ApiResponse::failed('Account not found');
    }
}
