<?php


namespace App\Http\Controllers\API\Auth;


use App\Helpers\AccountHelper;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Services\Pipes\CreateBankOneAccountPipe;
use App\Services\Pipes\CreateUserPipe;
use App\Services\Pipes\PrepareRegistrationPipe;
use Illuminate\Pipeline\Pipeline;

class RegisterRegisterController
{

    public function __invoke(RegisterRequest $request)
    {
        $requestData = $request->all();
        $requestData['reference'] = AccountHelper::reference();

        return app(Pipeline::class)
            ->send($requestData)
            ->through([
                PrepareRegistrationPipe::class,
                CreateUserPipe::class,
                CreateBankOneAccountPipe::class,
            ])
            ->thenReturn();
    }
}
