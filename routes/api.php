<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BalanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\WithdrawalFeeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReusableQuoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });

    Route::middleware('auth:api')->group(function () {
        // user endpoints
        Route::apiResource('user', UserController::class)
            ->except(['update', 'destroy', 'show']);
        Route::get("user/{endUserId}", [UserController::class, 'show'])->where([
            'endUserId' => '[A-Za-z0-9\-_]{1,250}'
        ]);
        Route::get("user/{endUserId}/address", [AddressController::class, 'index'])->where([
            'endUserId' => '[A-Za-z0-9\-_]{1,250}'
        ]);
        Route::get("user/{endUserId}/balances", [BalanceController::class, 'index'])->where([
            'endUserId' => '[A-Za-z0-9\-_]{1,250}'
        ]);

        // address endpoints
        Route::post("address", [AddressController::class, 'store']);

        // deposit endpoints
        Route::apiResource("deposit", DepositController::class)
            ->except(['store', 'update', 'destroy']);
        Route::get("deposit/{depositId}", [DepositController::class, 'show']);

        // withdrawal endpoints
        Route::apiResource("withdrawal", WithdrawalController::class)
            ->except(['update', 'destroy', 'show']);
        Route::get("withdrawal/{withdrawalId}", [WithdrawalController::class, 'show'])->where([
            'withdrawalId' => '[A-Za-z0-9\-_]{1,250}'
        ]);

        // withdrawaFee endpoints
        Route::apiResource("withdrawal-fee", WithdrawalFeeController::class)
            ->except(['store', 'show', 'update', 'destroy']);

        // transaction endpoints
        Route::apiResource("transaction", TransactionController::class)
            ->except(['update', 'destroy', 'store']);
        Route::get("transaction/{transactionId}", [TransactionController::class, 'show']);

        // rate endpoints
        Route::get('rate/historical/{pair}', [RateController::class, 'getHistoricalRates'])
            ->whereIn('pair', ['BTC_ARS', 'ETH_ARS', 'USDT_ARS', 'USDC_ARS', 'LTC_ARS', 'USDC_MXN', 'USDC_COP']);
        Route::apiResource("rate", RateController::class)
            ->except(['store', 'show', 'update', 'destroy']);

        // reusable quote endpoints
        Route::apiResource("reusable-quote", ReusableQuoteController::class)
            ->except(['update', 'destroy', 'show']);
    });
});
