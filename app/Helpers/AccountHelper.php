<?php


namespace App\Helpers;


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


    public static function normalize(string $balance) {
        if ( str_contains($balance, ',') ) {
            return Str::remove(',', $balance) *100.00;
        }
        return $balance;
    }


    public static function AsyncAccountBalance() {

    }


    public static function SyncAccountBalance(...$balances) {
        dd($balances);
    }
}
