<?php


namespace App\Http\Controllers\API;


use App\Helpers\AccountHelper;
use App\Helpers\ApiResponse;
use App\Http\Requests\API\IntraBankTransferRequest;
use App\Services\BankOne\BankOneFacade;
use App\Services\BankOne\DTOs\IntraBankTransferResponse;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObjectError;

class IntraBankTransfer
{

    public function __invoke(IntraBankTransferRequest $request): JsonResponse {
        $validated = $request->all();
        $narration = $validated['narration'] ?? sprintf('[amount] transfer to [receiver account name] [receiver account number]');
        $intraBankTransferPayload = [
            'Amount' => $validated['amount'] * 100.00,
            'FromAccountNumber' => $validated['from_account'],
            'ToAccountNumber' => $validated['to_account'],
            'RetrievalReference' => AccountHelper::intraTransferRef(),
            'Narration' => $narration,
            'AuthenticationKey' => config('services.bank_one.token'),
        ];

        $response = BankOneFacade::doIntraAccountTransfer($intraBankTransferPayload);
        try {
            $response = new IntraBankTransferResponse($response);
             if (! $response->IsSuccessful ) {
                 return ApiResponse::failed('Bank transfer failed. Please try again.');
             }

             if ( $response->ResponseCode === "00" ) {
                 //Async both account balances here
                 AccountHelper::AsyncAccountBalance($validated['from_account']);
                 AccountHelper::AsyncAccountBalance($validated['to_account']);
                 return ApiResponse::success('Bank Transfer successful');
             }

             if ( $response->ResponseCode === "X06") {
                 //run TSQ in another 60secs

             }
        } catch (DataTransferObjectError $e) {

        }

         return ApiResponse::failed('Bank transfer failed. Please try again');
    }
}
