<?php

namespace App\Services\BankOne\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class CreateAccountResponse extends DataTransferObject
{
    public bool $IsSuccessful;
    public $CustomerIDInString;
    public $Message;
    public $TransactionTrackingRef;
    public $Page;
}
