<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\NewDeviceController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\BalanceEnquiry;
use App\Http\Controllers\API\IntraBankTransfer;
use App\Http\Controllers\API\NameEnquiryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function() {

    Route::middleware('auth:sanctum')->group(function(){
        Route::post('balance-enquiry', BalanceEnquiry::class);
        Route::post('name-enquiry', NameEnquiryController::class);
        Route::post('intra-transfer', IntraBankTransfer::class);
    });

    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
    Route::post('authorize/{device_serial}/new-device/{user_id}', NewDeviceController::class)->name('authorize.new-device');
});

