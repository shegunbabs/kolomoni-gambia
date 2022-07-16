<?php


namespace App\Helpers;


use Illuminate\Support\Str;
use App\Models\User;

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
            'TT', Str::upper(Str::random(6)), substr(time(), -4)
        );
    }


    public static function normalize(string $balance) {
        if ( str_contains($balance, ',') ) {
            return Str::remove(',', $balance) *100.00;
        }
        return $balance;
    }


    public static function AsyncAccountBalance() {

    }


    public static function SyncAccountBalance(User $user, $balances) {

        $available_bal = static::normalize($balances['AvailableBalance']);
        $ledger_bal = static::normalize($balances['LedgerBalance']);
        $withdrawable_bal = static::normalize($balances['WithdrawableBalance']);

        $account = $user->account;

        if ( $withdrawable_bal !== $account->withdrawable_balance ) {
            tap($account)->update([
                'available_balance' => $available_bal,
                'ledger_balance' => $ledger_bal,
                'withdrawable_balance' => $withdrawable_bal,
            ]);
        }

    }
}
