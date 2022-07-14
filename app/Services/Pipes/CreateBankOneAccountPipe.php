<?php


namespace App\Services\Pipes;

use App\Helpers\ApiResponse;
use App\Http\Resources\UserAccountResource;
use App\Http\Resources\UserResource;
use App\Services\BankOne\BankOneFacade;
use App\Services\BankOne\DTOs\CreateAccountResponse;
use Closure;

class CreateBankOneAccountPipe
{


    public function handle(array $data, Closure $next) {

        $payload = $data['bankOnePayload'];
        $response = BankOneFacade::createAccount($payload);
        $response = new CreateAccountResponse($response);
        if (! $response->IsSuccessful ) {
            $errorMessage = $response->Message['CreationMessage'] ?? 'Error Creating Account on BankOne';
            return ApiResponse::failed($errorMessage);
        }
        unset($data['bankOnePayload']);
        $user = $data['user'];
        $user->account()->create([
            'transaction_tracking_ref' => $data['reference'],
            'account_number' => $response->Message['AccountNumber'],
            'bankone_account_number' => $response->Message['BankoneAccountNumber'],
            'customer_id' => $response->Message['CustomerID'],
            'available_balance' => 0.00,
            'withdrawable_balance' => 0.00,
            'account_officer_code' => config('services.bank_one.account_officer_code'),
            'account_tier' => 1,
        ]);

        $out['user'] = new UserResource($user);
        $out['token'] = $data['token'];
        $out['fcm_token'] = $data['fcm_token'];
        $out['account'] = new UserAccountResource($user->account);

        return ApiResponse::success('Account created successfully', $out);
    }
}
