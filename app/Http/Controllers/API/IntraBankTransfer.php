<?php


namespace App\Http\Controllers\API;


use App\Helpers\AccountHelper;
use App\Helpers\ApiResponse;
use App\Helpers\Narrations;
use App\Http\Requests\API\IntraBankTransferRequest;
use App\Models\Account;
use App\Services\BankOne\BankOneFacade;
use App\Services\BankOne\DTOs\IntraBankTransferResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObjectError;

class IntraBankTransfer
{

    public function __invoke(IntraBankTransferRequest $request): JsonResponse {
        $validated = $request->all();
        $fromAccountModel = Account::with('user')->where('bankone_account_number', $validated['to_account'])->first();
        //$toAccountModel = Account::with('user')->where('bankone_account_number', $validated['to_account'])->first();

        $narration = Narrations::intraTransferFromNarration($fromAccountModel, $validated['amount']);

        $intraBankTransferPayload = [
            'Amount' => $validated['amount'] * 100.00,
            'FromAccountNumber' => $validated['from_account'],
            'ToAccountNumber' => $validated['to_account'],
            'RetrievalReference' => AccountHelper::intraTransferRef(),
            'Narration' => Str::limit($validated['narration'] ?? $narration, 100, ''),
            'AuthenticationKey' => config('services.bank_one.token'),
        ];

        $response = BankOneFacade::doIntraAccountTransfer($intraBankTransferPayload);
        try {
            $response = new IntraBankTransferResponse($response);
             if (! $response->IsSuccessful ) {
                 return ApiResponse::failed($response->ResponseMessage);
             }

             if ( $response->ResponseCode === "00" ) {
                 return ApiResponse::success('Bank transfer successful.');
             }

             if ( Str::lower($response->ResponseCode) === 'x06' ) {
                 //requery here
                 return ApiResponse::pending('Bank transfer pending.');
             }

        } catch (DataTransferObjectError $e) {
            ApiResponse::failed($e->getMessage());
        }

         return ApiResponse::failed('Bank transfer failed. Please try again');
    }
}
