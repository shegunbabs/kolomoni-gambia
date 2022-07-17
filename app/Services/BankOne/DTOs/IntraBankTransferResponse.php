<?php


namespace App\Services\BankOne\DTOs;


use Spatie\DataTransferObject\DataTransferObject;

class IntraBankTransferResponse extends DataTransferObject
{

    public bool $IsSuccessful;
    public $ResponseMessage;
    public $ResponseCode;
    public $Reference;
}
