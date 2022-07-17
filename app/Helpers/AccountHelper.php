<?php


namespace App\Helpers;


use App\Models\Account;
use App\Services\BankOne\BankOneFacade;
use Illuminate\Support\Str;

class AccountHelper
{

    public static function reference(): string {
        return sprintf(
            'KOL|ACCT|%s%s',
            Str::upper(Str::random(6)),
            substr(time(), -4)
        );
    }


    public static function intraTransferRef(): string {
        return sprintf(
            '%s|%s|%s',
            'TT', Str::upper(Str::random(4)), substr(time(), -4)
        );
    }


    public static function normalize(string $balance) {
        if ( str_contains($balance, ',') ) {
            return Str::remove(',', $balance) * 100.00;
        }
        return $balance * 100.00;
    }


    public static function AsyncAccountBalance($accountNumber): void
    {
        $accountModel = Account::query()->where('bankone_account_number', $accountNumber)->first();
        $accountNumber = $accountModel->account_number;

        dispatch( static function() use ($accountNumber, $accountModel) {
            $response = BankOneFacade::balanceEnquiry($accountNumber);
            if (!$response['AvailableBalance']) {
                static::SyncAccountBalance($accountModel, $response);
            }
        });
    }


    /**
     * @param Account $accountModel
     * @param array $balances
     */
    public static function SyncAccountBalance(Account $accountModel, array $balances): void {

        $available_bal = static::normalize($balances['AvailableBalance']);
        $ledger_bal = static::normalize($balances['LedgerBalance']);
        $withdrawable_bal = static::normalize($balances['WithdrawableBalance']);

        if ( $available_bal !== $accountModel->available_balance ) {
            tap($accountModel)->update([
                'available_balance' => $available_bal,
                'ledger_balance' => $ledger_bal,
                'withdrawable_balance' => $withdrawable_bal,
            ]);
        }
    }
}
