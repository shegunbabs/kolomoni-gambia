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
}
