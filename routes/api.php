<?php

use App\Http\Controllers\Binance;
use App\Http\Controllers\BinanceFuture;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BinanceTest;

//--------------------------------------------------------

// ===================== binance start ===========

// ============ binance spot ==============

Route::get('/binance/tradespot/{startTime}/{endTime}/{firstSymbol}/{secondSymbol}/{apiKey}/{secretKey}', [Binance::class, 'myTrade']);



Route::get('/binance/tradespottest/{startTime}/{endTime}/{firstSymbol}/{secondSymbol}/{apiKey}/{secretKey}', [Binance::class, 'myTradeTest']);
// ============= binane spot end =================


// =============================== binance future ======



Route::get('/binance/position-history/{symbol}/{apiKey}/{secretKey}', [BinanceFuture::class, 'positionHistory']);
Route::get('/binance/all-order/{symbol}/{apiKey}/{secretKey}', [BinanceFuture::class, 'positionAllOrder']);

// ====================

Route::get('/binance/open-orders/{apiKey}/{secretKey}/{symbol}', [BinanceFuture::class, 'openOrders']);
Route::get('/binance/positions/{apiKey}/{secretKey}', [BinanceFuture::class, 'positions']);
Route::get('/binance/trade-history/{apiKey}/{secretKey}/{symbol}', [BinanceFuture::class, 'tradeHistory']);
// ============================= binance future end =============

// =========================== binance spot start =================
// Route::get('/binance/accountsnap/{timestamp}/{apiKey}/{secretKey}', [Binance::class, 'getAccountSnapshot']);
// Route::get('/binance/extrabalance/{apiKey}/{secretKey}', [Binance::class, 'extractBalances']);
// Route::
// get('/binance/deposits/{startTime}/{endTime}/{apiKey}/{secretKey}', [Binance::class, 'getDeposits']);
// Route::get('/binance/withdraw/{startTime}/{endTime}/{apiKey}/{secretKey}', [Binance::class, 'getWithdrawals']);
// ========================= binance spot end ===================

// ======================== binance deposit & withdraw
Route::get('/binance/deposit-history/{apiKey}/{secretKey}', [Binance::class, 'depositRangeHistory']);
Route::get('/binance/withdraw-history/{apiKey}/{secretKey}', [Binance::class, 'withdrawRangeHistory']);
Route::get('/binance/wallet/{apiKey}/{secretKey}', [Binance::class, 'walletBalanceAndAsset']);
// ============ verify account ============
Route::get('/binance/verifyaccount/{apiKey}/{secretKey}', [Binance::class, 'verifyAccount']);
// ================ binance deposit & withdraw end

// ------------------------------------------------------


Route::get('/binance', [BinanceTest::class, 'getAccountInfo']);

Route::get('/binance/time', [BinanceTest::class, ' checkTime']);

Route::get('/binance/exchangeinfo', [BinanceTest::class, 'exchangePair']);
Route::get('/binance/mytrade', [BinanceTest::class, 'myTrade']);

Route::get('/binance/tradehistory', [BinanceTest::class, 'myTradeHistory']);

Route::get('/binance/withdraw', [BinanceTest::class, 'myWithdraw']);

Route::get('/binance/deposit', [BinanceTest::class, 'myDeposit']);
Route::get('/binance/acctinfo', [BinanceTest::class, 'myAccountInfo']);

Route::get('/binance/spotbalance', [BinanceTest::class, 'myBalanceSpot']);

Route::get('/binance/futurebalance', [BinanceTest::class, 'myBalanceFutures']);
Route::get('/binance/balance', [BinanceTest::class, 'myBalance']);
Route::get('/binance/asset', [BinanceTest::class, 'userAsset']);

Route::get('/binance/allorder', [BinanceTest::class, 'getAllOrder']);








// Route::get('/Binance/time', function () {
//     $BinanceTest = new BinanceTest\Spot();

//     $servertime = $BinanceTest->time();
//     // var_dump($servertime);
//     $serverTime = $servertime['serverTime'];

//     $laptopTime = now()->timestamp * 1000;
//     $diff = $serverTime - $laptopTime;
//     $adjustedLaptopTime = $laptopTime + $diff;

//     return response()->json([
//        "server_time" =>  $BinanceTest->time(),
//        "laptop_time" => $laptopTime,
//        "diff" => $diff,
//        "adjusted_time" => $adjustedLaptopTime + 1200
//         ]);

// });

// Route::get('/Binance/account', function () {
//     $BinanceTest = new BinanceTest\Spot([
//         'key' => 'RXf8O7WU63cr4E6BROxwMpiZrAJYrbzoJW3selbxScEZ02xqfiWBcUFro7IwCPyQ',
//         'secret' => 'ylfoM9jEs5pKNMv8JuXOMSw5WyjoU02Kyi42XynJDYc7t4IidIsd9DSZGtXxtwOS'
//     ]);
//     return response()->json($BinanceTest->account());
// });
