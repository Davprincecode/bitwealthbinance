<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Binance;

Route::get('/', function () {
    return "hello world";
});



Route::get('/binance', [Binance::class, 'getAccountInfo']);

Route::get('/binance/mytrade', [Binance::class, 'myTrade']);

Route::get('/binance/tradehistory', [Binance::class, 'myTradeHistory']);

Route::get('/binance/withdraw', [Binance::class, 'myWithdraw']);

Route::get('/binance/deposit', [Binance::class, 'myDeposit']);
Route::get('/binance/acctinfo', [Binance::class, 'myAccountInfo']);

Route::get('/binance/spotbalance', [Binance::class, 'myBalanceSpot']);

Route::get('/binance/futurebalance', [Binance::class, 'myBalanceFutures']);
Route::get('/binance/balance', [Binance::class, 'myBalance']);
Route::get('/binance/asset', [Binance::class, 'userAsset']);


Route::get('/binance/allorder', [Binance::class, 'getAllOrder']);








// Route::get('/binance/time', function () {
//     $binance = new Binance\Spot();

//     $servertime = $binance->time();
//     // var_dump($servertime);
//     $serverTime = $servertime['serverTime'];

//     $laptopTime = now()->timestamp * 1000;
//     $diff = $serverTime - $laptopTime;
//     $adjustedLaptopTime = $laptopTime + $diff;

//     return response()->json([
//        "server_time" =>  $binance->time(),
//        "laptop_time" => $laptopTime,
//        "diff" => $diff,
//        "adjusted_time" => $adjustedLaptopTime + 1200
//         ]);

// });

// Route::get('/binance/account', function () {
//     $binance = new Binance\Spot([
//         'key' => 'RXf8O7WU63cr4E6BROxwMpiZrAJYrbzoJW3selbxScEZ02xqfiWBcUFro7IwCPyQ',
//         'secret' => 'ylfoM9jEs5pKNMv8JuXOMSw5WyjoU02Kyi42XynJDYc7t4IidIsd9DSZGtXxtwOS'
//     ]);
//     return response()->json($binance->account());
// });
