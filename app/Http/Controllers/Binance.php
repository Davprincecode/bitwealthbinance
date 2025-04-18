<?php

namespace App\Http\Controllers;

use Binance\Futures;
use Binance\Spot;
use Illuminate\Http\Request;

class Binance extends Controller
{
    //
    protected $api;

    // $api = new Spot([
    //     'key' => 'v83VOrFC6b1yq3tbdoGRMj7l0bYyGnb589z6MhA6L3z4nM9ejJGTCO2sfHhYK7qD',
    //     'secret' => '0jThJwNQBIu35cJtWAHulsTWrpD9PunGdAEi53nvBIxqd746eojx9EanBex1OFgO'
    // ]);

    public function __construct()
    {
        $api = new Spot([
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

    // 1668017244486

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



public function myTrade($startTime, $endTime, $firstSymbol, $secondSymbol, $apiKey, $secretKey)
{

    try {
        $api = new Spot([
        'key' => $apiKey,
        'secret' => $secretKey
         ]);
        $params = [
            'timestamp' => $this->syncServerTime(),
            // 'startTime' => $startTime,
            // 'endTime' => $endTime
        ];
        $symbol = $firstSymbol.$secondSymbol;

        $response = $api->myTrades($symbol, $params);

        // $balance = $this->getBalanceAtTime($apiKey, $secretKey, $startTime, $firstSymbol, $secondSymbol);

        return response()->json([
               "status" => true,
               "data" => [
                "trade" => $response,
                // "balance" => $balance
               ]
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
public function myTradeTest($startTime, $endTime, $firstSymbol, $secondSymbol, $apiKey, $secretKey)
{

    try {
        $api = new Spot([
        'key' => $apiKey,
        'secret' => $secretKey
         ]);
        $params = [
            'timestamp' => $this->syncServerTime()
            // ,
            // 'startTime' => $startTime,
            // 'endTime' => $endTime
        ];
        $symbol = $firstSymbol.$secondSymbol;

        $response = $api->myTrades($symbol, $params);

        $balance = $this->getBalanceAtTime($apiKey, $secretKey, $startTime, $firstSymbol, $secondSymbol);

        return response()->json([
               "status" => true,
               "data" => [
                "trade" => $response,
                "balance" => $balance
               ]
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


// =================================== get user balance================================

public function getBalanceAtTime($apiKey, $secretKey, $timestamp, $firstSymbol, $secondSymbol)
{
    $previousDayTimestamp = $this->getPreviousDayTimestamp($timestamp);

    // 1️⃣ Get account snapshot from the previous day

    $snapshot = $this->getAccountSnapshot($apiKey, $secretKey, $previousDayTimestamp);

    // $balances = $this->extractBalances($snapshot, [$secondSymbol, $firstSymbol]);

    // 2️⃣ Fetch deposits & withdrawals for the target day

    // $deposits = $this->getDeposits($apiKey, $secretKey, $previousDayTimestamp, $timestamp);
    // $withdrawals = $this->getWithdrawals($apiKey, $secretKey, $previousDayTimestamp, $timestamp);

    // 3️⃣ Apply transactions to update balances

    // $finalBalance = $this->calculateBalance($balances, $deposits, $withdrawals);

    return $snapshot;
}

private function getPreviousDayTimestamp($timestamp)
{
    // return strtotime('-1 day', $timestamp / 1000) * 1000;

    // Convert milliseconds to seconds as integer
    $seconds = (int)($timestamp / 1000);

    // Get previous day's timestamp in seconds
    $previousDaySeconds = strtotime('-1 day', $seconds);

    // Convert back to milliseconds
    return $previousDaySeconds * 1000;
}

public function getAccountSnapshot($apiKey, $secretKey, $timestamp)
{
    try {
        $api = new Spot([
            'key' => $apiKey,
            'secret' => $secretKey
             ]);
        return response()->json($api->accountSnapshot("SPOT", [
            'timestamp' =>  $this->syncServerTime(),
            // 'startTime' => $timestamp,
            //  'endTime' => $timestamp
        ]));

    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }

}

private function extractBalances($snapshot, $assets)
{
    $balances = [];
    if($snapshot['error']){
        return $balances;
    }
    foreach ($snapshot['snapshotVos'] ?? [] as $entry) {
        foreach ($entry['data']['balances'] as $balance) {
            if (in_array($balance['asset'], $assets)) {
                $balances[$balance['asset']] = (float) $balance['free'];
            }
        }
    }
    return $balances;
}

public function getDeposits($apiKey, $secretKey, $startTime, $endTime)
{
    try {
        $api = new Spot([
            'key' => $apiKey,
            'secret' => $secretKey
             ]);
        return response()->json($api->depositHistory([
            'timestamp' =>  + $this->syncServerTime(),
            'startTime' => $startTime,
            'endTime' => $endTime
        ]));
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

public function getWithdrawals($apiKey, $secretKey, $startTime, $endTime)
{
    try {
        $api = new Spot([
            'key' => $apiKey,
            'secret' => $secretKey
             ]);
        return response()->json($api->withdrawHistory([
            'timestamp' =>  + $this->syncServerTime(),
            'startTime' => $startTime,
            'endTime' => $endTime
        ]));
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

private function calculateBalance($balances, $deposits, $withdrawals)
{
    foreach ($deposits as $deposit) {
        if ($deposit['status'] == 1) {
            $balances[$deposit['coin']] += (float) $deposit['amount'];
        }
    }

    foreach ($withdrawals as $withdrawal) {
        if ($withdrawal['status'] == 1) {
            $balances[$withdrawal['coin']] -= ((float) $withdrawal['amount'] + (float) $withdrawal['transactionFee']);
        }
    }

    return $balances;
}

public function depositRangeHistory($apiKey, $secretKey){
    try {
        $api = new Spot([
            'key' => $apiKey,
            'secret' => $secretKey
        ]);
        return response()->json($api->depositHistory([
            'timestamp' =>  + $this->syncServerTime()
        ]));
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

public function withdrawRangeHistory($apiKey, $secretKey){

    try {
        $api = new Spot([
            'key' => $apiKey,
            'secret' => $secretKey
        ]);
        return response()->json($api->withdrawHistory([
            'timestamp' =>  + $this->syncServerTime()
        ]));
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
public function walletBalanceAndAsset($apiKey, $secretKey){
    try {
        $api = new Spot([
            'key' => $apiKey,
            'secret' => $secretKey
        ]);
        $balance = $api->queryUserWalletBalance([
            'timestamp' =>  $this->syncServerTime()
        ]);
        // $asset = $api->userAsset([
        //     'timestamp' =>  $this->syncServerTime()
        // ]);
        return response()->json([
            'status' => 'true',
            'data' =>  $balance
        ], 200);
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

public function verifyAccount($apiKey, $secretKey){
    try {
        $api = new Spot([
            'key' => $apiKey,
            'secret' => $secretKey
        ]);

        $data = $api->accountInfo([
            'timestamp' =>  + $this->syncServerTime()
        ]);
        return response()->json([
            'status' => "true",
            'data' => $data
        ], 200);
    } catch (\Exception $e) {

        return response()->json([
            'status' => "false",
            'message' => $e->getMessage()
        ], 500);
    }
}


}
