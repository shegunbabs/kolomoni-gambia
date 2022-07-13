<?php


namespace App\Services\Pipes;

use Closure;

class PrepareRegistrationPipe
{

    public function handle(array &$data, Closure $next) {

        $data['fullname'] = "{$data['lastname']} {$data['firstname']}";

        $accountOpeningPayload = [
            "TransactionTrackingRef" => $data['reference'],
            "CustomerID" => "",
            "AccountReferenceNumber" => "",
            "AccountOpeningTrackingRef" => "",
            "OtherNames" => "",
            'FirstName' => $data['firstname'],
            'MiddleName' => "",
            'LastName' => $data['lastname'],
            "AccountName" => $data['fullname'],
            "BVN" => $data['tin'],
            "FullName" => $data['fullname'],
            "PlaceOfBirth" => "",
            "NationalIdentityNo" => "",
            "NextOfKinPhoneNo" => "",
            "NextOfKinName" => "",
            "ReferralPhoneNo" => "",
            "ReferralName" => "",
            "HasSufficientInfoOnAccountInfo" => true,
            "AccountInformationSource" => 0,
            "OtherAccountInformationSource" => "",
            "AccountOfficerCode" => config('services.bank_one.account_officer_code'),
            "AccountNumber" => "",
            "CustomerImage" => "",
            "CustomerSignature" => "",
            "NotificationPreference" => 0,
            "TransactionPermission" => 0,
            "AccountTier" => 1,
            'Email' => $data['email'],
            'DateOfBirth' => $data['dob'],
            'Gender' => 0,
            'Address' => "",
            'PhoneNo' => $data['phone'],
            'ProductCode' => config('services.bank_one.product_code'),
        ];
        $data['bankOnePayload'] = $accountOpeningPayload;

        return $next($data);
    }
}
