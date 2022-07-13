<?php


namespace App\Services\BankOne;


use Illuminate\Support\Facades\Facade;

/**
 * Class BankOneFacade
 * @package App\Services\BankOne
 * @method static getAccountByAccountNumber(string $accountNumber)
 * @method static getAccountByCustomerId(string $customerID)
 * @method static balanceEnquiry(string $customerID)
 * @method static doNameEnquiry(string $accountNumber)
 * @method static getTransactions(string $accountNumber, string $fromDate, $toDate = null, int $numberOfItems = 200)
 * @method static createAccount(array $payload)
 */

class BankOneFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'BankOne';
    }
}
