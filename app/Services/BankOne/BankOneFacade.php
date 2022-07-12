<?php


namespace App\Services\BankOne;


use Illuminate\Support\Facades\Facade;

class BankOneFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'BankOne';
    }
}
