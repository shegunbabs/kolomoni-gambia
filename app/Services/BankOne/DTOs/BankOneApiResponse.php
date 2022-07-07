<?php


namespace App\Services\BankOne\DTOs;


use Spatie\DataTransferObject\DataTransferObject;

class BankOneApiResponse extends DataTransferObject
{
    public bool $IsSuccessful;
    public $CustomerIDInString;
    public $Message;
    public $TransactionTrackingRef;
    public $Page;
}
