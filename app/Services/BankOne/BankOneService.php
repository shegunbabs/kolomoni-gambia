<?php

namespace App\Services\BankOne;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class BankOneService
{

    private const BASE_URL = 'https://api.mybankone.com/BankOneWebAPI/api';
    //private const BASE_URL = 'http://52.168.85.231/BankOneWebAPI';

    private const CREATE_ACCOUNT = '/Account/CreateAccountQuick/2';
    private const CLOSE_ACCOUNT = '/Account/CloseAccount/2';
    private const DO_FUNDS_TRANSFER = '/Account/DoFundsTransfer/2';
    private const GET_ACCOUNT_BY_ACCOUNT_NUMBER = '/Account/GetAccountByAccountNumber/2';
    private const GET_ACCOUNT_BY_CUSTOMER_ID = '/Account/GetActiveSavingsAccountsByCustomerID/2';
    private const DO_NAME_ENQUIRY = '/Account/DoNameEnquiry/2';
    private const GET_TRANSACTIONS = '/Account/GetTransactions/2';


    public function __construct(){}


    public function getTransactions(string $accountNumber, string $fromDate, $toDate = null, int $numberOfItems = 200) {

        $payload = [
            'accountNumber' => $accountNumber,
            'fromDate' => Carbon::createFromFormat('Y-m-d', $fromDate)->format('Y-m-d'),
            'toDate' => $toDate ?? now()->format('Y-m-d'),
            'numberOfItems' => $numberOfItems,
            'institutionCode' => config('services.bank_one.mfb_code')
        ];
        $url = $this->buildUrl(self::GET_TRANSACTIONS) . '&' . http_build_query($payload);
        return $this->get($url);


    }


    public function doNameEnquiry($accountNumber): array {
        $url = $this->buildUrl(self::DO_NAME_ENQUIRY);
        $url = sprintf('%s&accountNumber=%s&institutionCode=%s', $url, $accountNumber, config('services.bank_one.mfb_code'));
        return $this->post($url, );
    }


    public function balanceEnquiry(string $customerID) {
        return $this->getAccountByCustomerId($customerID);
    }


    public function getAccountByCustomerId(string $customerID): array
    {
        $url = $this->buildUrl(self::GET_ACCOUNT_BY_CUSTOMER_ID);
        return $this->get($url, ['customerId' => $customerID]);
    }


    /**
     * @param array $payload array<string string> ['accountNumber' => <string>, 'computewithdrawableBalance' => <bool>]
     */
    public function getAccountByAccountNumber(array $payload): array {
        try {
            $url = $this->buildUrl(self::GET_ACCOUNT_BY_ACCOUNT_NUMBER);
            return $this->get($url, $payload);
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    protected function post(string $url, array $params = null): array {
        $res = Http::post($url, $params);
        return $this->response($res);
    }


    protected function get(string $url, $params = null): array {
        $url = $params
            ? $url. '&' .http_build_query($params)
            : $url;
        $res = Http::get($url);
        return $this->response($res);
    }


    private function response(Response $response): array {
        return $response->ok() && $response->json()
            ? $response->json()
            : [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
            ];
    }


    private function buildUrl($path): string
    {
        return sprintf(
            '%s%s?authtoken=%s',
            self::BASE_URL,
            $path,
            config('services.bank_one.token')
        );
    }


    public function createAccount(array $payload): array
    {
        $url = $this->buildUrl(self::CREATE_ACCOUNT);
        return $this->post($url, $payload);
    }


    public function closeAccount(array $payload): array
    {
        $url = $this->buildUrl(self::CLOSE_ACCOUNT);
        $url .= '&' . ltrim(http_build_query($payload), '?');
        return $this->post($url, $payload);
    }


    public function fundsTransfer(array $payload): array {
        $url = $this->buildUrl(self::DO_FUNDS_TRANSFER);
        return $this->post($url, $payload);
    }
}
