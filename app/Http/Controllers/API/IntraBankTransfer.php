<?php


namespace App\Http\Controllers\API;


use App\Helpers\AccountHelper;
use App\Http\Requests\API\IntraBankTransferRequest;
use App\Services\BankOne\BankOneFacade;
use Illuminate\Http\JsonResponse;

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



    }
}
