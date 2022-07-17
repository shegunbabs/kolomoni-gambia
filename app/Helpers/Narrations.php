<?php


namespace App\Helpers;


use App\Models\Account;

class Narrations
{

    public static function intraTransferFromNarration(Account $accountModel, $amount): string {
        return sprintf(
            'N%s Bank transfer to %s %s',
            $amount,
            ucwords($accountModel->user->fullname),
            $accountModel->bankone_account_number,
        );
    }


    public static function intraTransferToNarration(Account $accountModel, $amount): string {
        return sprintf(
            'N%s received from %s %s via Bank transfer',
            $amount,
            $accountModel->user->fullname,
            $accountModel->bankone_account_number,
        );
    }
}
