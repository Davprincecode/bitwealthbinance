<?php

namespace App\Http\Controllers;

use Binance\Futures;
use Binance\Spot;
use Illuminate\Http\Request;

class Binance extends Controller
{
    //
    protected $api;

    // $this->api = new Spot([
    //     'key' => 'v83VOrFC6b1yq3tbdoGRMj7l0bYyGnb589z6MhA6L3z4nM9ejJGTCO2sfHhYK7qD',
    //     'secret' => '0jThJwNQBIu35cJtWAHulsTWrpD9PunGdAEi53nvBIxqd746eojx9EanBex1OFgO'
    // ]);

    public function __construct()
    {
        $this->api = new Spot([
            // 'key' => 'nZCT8PkhJL7mQloPeE1velhBEf2GIl0peF6qn7BnJoyWKy1d6i74nRAqgOIfnVEi',
            // 'secret' => 'y6Web7GZX5t7pffasRRtmJO1H6UU5dDGfctFIVUEjmWey0UNcOZOYQS04NK1rziW'

        'key' => 'v83VOrFC6b1yq3tbdoGRMj7l0bYyGnb589z6MhA6L3z4nM9ejJGTCO2sfHhYK7qD',
        'secret' => '0jThJwNQBIu35cJtWAHulsTWrpD9PunGdAEi53nvBIxqd746eojx9EanBex1OFgO'

        // 'key' => 'P3jlSw2QSps6dSK52rEQxXbIiSnI6SS5d09xGpupvfYLVGdFsNAjLP8JDQ4qGgNC',
        // 'secret' => 'xyly5WesyjRdVZWw2f8nTZnHgViFYiuoWDoQk9iKnc9dOVo3mxACzJj9Q2358rOM'


        // 'key' => 'C55tjUNhmg9M4F86BYSI3lZG5tL7HieDldmepcHy7tcPezviYbtCB8QPAsmcWQfQ',
        // 'secret' => 'td1k0Y3Fv8EJxAn2fqqYtNJgx8k9TEaEQOudn60iMecZkxKUpTgYa4n5S6xiXe22'
        ]);


    }

   private function syncServerTime()
    {
        $binance = new Spot();
        $servertime = $binance->time();
    $serverTime = $servertime['serverTime'];

    $laptopTime = now()->timestamp * 1000;
    $diff = $serverTime - $laptopTime;
    $adjustedLaptopTime = $laptopTime + $diff ;

    return $adjustedLaptopTime + 1200;
    }


    private function checkTime()
    {
        $binance = new Spot();
    $servertime = $binance->time();
    $serverTime = $servertime['serverTime'];

    $laptopTime = now()->timestamp * 1000;
    $diff = $serverTime - $laptopTime;
    $adjustedLaptopTime = $laptopTime + $diff ;

    return response()->json([
           "binance_time" => $serverTime,
            "laptop_time" => $laptopTime,
            "diff" => $diff,
            "adjusted_time" => $adjustedLaptopTime
    ], 200);
    }


    public function getAccountInfo()
    {
        try {
            // var_dump($this->api->account([
            //     'timestamp' =>  + $this->syncServerTime()
            // ]));
            // return $this->api->account();




            return response()->json($this->api->account([
                'timestamp' =>  + $this->syncServerTime()
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

public function getAllOrder(Request $request){
    try {

        return response()->json($this->api->allOrders("BNBUSDT",[
            'timestamp' =>  + $this->syncServerTime()
        ]));
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
    public function myDeposit(){
        try {

            return response()->json($this->api->depositHistory([
                'timestamp' =>  + $this->syncServerTime()
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function myWithdraw(){
        try {

            return response()->json($this->api->withdrawHistory([
                'timestamp' =>  + $this->syncServerTime()
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function myTransfer(){
        // try {

        //     return response()->json($this->api->universalTransferHistory([
        //         'timestamp' =>  + $this->syncServerTime()
        //     ]));
        // } catch (\Exception $e) {
        //     return ['error' => $e->getMessage()];
        // }
    }

    public function myAccountInfo(){
        try {

            return response()->json($this->api->accountInfo([
                'timestamp' =>  + $this->syncServerTime()
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function myBalanceSpot(){
        try {

            return response()->json($this->api->accountSnapshot("SPOT", [
                'timestamp' =>  $this->syncServerTime()
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function myBalanceFutures(){
        try {

            return response()->json($this->api->accountSnapshot("FUTURES", [
                'timestamp' =>  $this->syncServerTime()
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    public function myBalance(){
        try {

            return response()->json($this->api->queryUserWalletBalance([
                'timestamp' =>  $this->syncServerTime()
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function userAsset(){
        try {

            return response()->json($this->api->userAsset([
                'timestamp' =>  $this->syncServerTime()
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function exchangePair()
{
    try {
        // Fetch all ticker prices
        $response = $this->api->tickerPrice();

        // Filter pairs ending with 'USDT'
        $usdtPairs = collect($response)->filter(function ($pair) {
            return str_ends_with($pair['symbol'], 'USDT');
        })->values();

        return response()->json($usdtPairs);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function myTrade()
{
    try {
        $params = [
            'timestamp' => $this->syncServerTime(),
            'startTime' => "1668017244486",
            'endTime' => "1668283966711"
        ];

        $response = $this->api->myTrades("XRPUSDT", $params);

        return response()->json($response);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function myTradeHistory(){
        try {

                //    $this->api->payTradeHistory()
                // /sapi/v1/pay/transactions

                //    $this->api->c2cTradeHistory()
                // /sapi/v1/c2c/orderMatch/listUserOrderHistory

                // $this->api->nftTransactionHistory
                // $this->api->historicalTrades()

                // $this->api->futuresAccount();

            return response()->json($this->api->payTradeHistory([
                'timestamp' =>  + $this->syncServerTime()
            ]));
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }






}
