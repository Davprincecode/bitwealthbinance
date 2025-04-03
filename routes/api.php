<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BinanceTest;


// ===================== binance start ===========

// ============ binance end ==============


// ============= binane test below start =================

Route::get('/Binance', [BinanceTest::class, 'getAccountInfo']);

Route::get('/Binance/time', [BinanceTest::class, ' checkTime']);

Route::get('/Binance/exchangeinfo', [BinanceTest::class, 'exchangePair']);
Route::get('/Binance/mytrade', [BinanceTest::class, 'myTrade']);

Route::get('/Binance/tradehistory', [BinanceTest::class, 'myTradeHistory']);

Route::get('/Binance/withdraw', [BinanceTest::class, 'myWithdraw']);

Route::get('/Binance/deposit', [BinanceTest::class, 'myDeposit']);
Route::get('/Binance/acctinfo', [BinanceTest::class, 'myAccountInfo']);

Route::get('/Binance/spotbalance', [BinanceTest::class, 'myBalanceSpot']);

Route::get('/Binance/futurebalance', [BinanceTest::class, 'myBalanceFutures']);
Route::get('/Binance/balance', [BinanceTest::class, 'myBalance']);
Route::get('/Binance/asset', [BinanceTest::class, 'userAsset']);

Route::get('/Binance/allorder', [BinanceTest::class, 'getAllOrder']);








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
