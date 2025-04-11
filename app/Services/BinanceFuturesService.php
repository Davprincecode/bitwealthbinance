<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BinanceFuturesService
{
    protected $apiKey;
    protected $apiSecret;
    protected $baseUrl;

    public function __construct()
    {
        // $this->apiKey = env('BINANCE_API_KEY');
        // $this->apiSecret = env('BINANCE_API_SECRET');
        // $this->baseUrl = env('BINANCE_FUTURES_BASE_URL');

        // https://fapi.binance.com


        // $this->apiKey = 'v83VOrFC6b1yq3tbdoGRMj7l0bYyGnb589z6MhA6L3z4nM9ejJGTCO2sfHhYK7qD';
        // $this->apiSecret = '0jThJwNQBIu35cJtWAHulsTWrpD9PunGdAEi53nvBIxqd746eojx9EanBex1OFgO';
        // $this->baseUrl = 'fapi.binance.com';

        // $this->apiKey = 'P3jlSw2QSps6dSK52rEQxXbIiSnI6SS5d09xGpupvfYLVGdFsNAjLP8JDQ4qGgNC';
        // $this->apiSecret = 'xyly5WesyjRdVZWw2f8nTZnHgViFYiuoWDoQk9iKnc9dOVo3mxACzJj9Q2358rOM';

        // $this->apiKey = '1c9c2e1837b75f91ee5bbd0b3d15ef5571868946644c8a0da5ed2e8d461fbb1c';
        // $this->apiSecret = '38dc061581dfb14a693b61eaa4d637e1de0c98129635f2c672b5f993a6ec3d2b';


        $this->baseUrl = "https://testnet.binancefuture.com";
    }

    /**
     * Generate a Binance API signature
     */
    private function generateSignature($params)
    {
        return hash_hmac('sha256', http_build_query($params), $this->apiSecret);
    }

    /**
     * Make an HTTP request to Binance Futures API
     */
    private function makeRequest($method, $endpoint, $params = [], $isSigned = false)
    {
        $url = $this->baseUrl . $endpoint;

        if ($isSigned) {
            $params['timestamp'] = round(microtime(true) * 1000);
            $params['signature'] = $this->generateSignature($params);
        }

        $headers = [
            'X-MBX-APIKEY' => $this->apiKey,
        ];

        $response = Http::withHeaders($headers)->$method($url, $params);

        return $response->json();
    }

    /**
     * Get Open Orders
     */
    public function getOpenOrders($apiKey, $secretKey, $symbol)
    {
         $this->apiKey = $apiKey;
         $this->apiSecret = $secretKey;
        // return $this->makeRequest('get', '/fapi/v1/openOrders',  ['symbol' => $symbol], true);

        return response()->json([
            'apiKey' => $this->apiKey,
            'secretKey' => $this->apiSecret
        ], 200);
    }


    /**
     * Get Open Positions
     */
    public function getPositions($apiKey, $secretKey)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $secretKey;
        return $this->makeRequest('get', '/fapi/v3/positionRisk', [], true);
    }

    /**
     * Get Position History (Account Trades)
     */
    public function getPositionHistory($symbol)
    {
        return $this->makeRequest('get', '/fapi/v1/userTrades', ['symbol' => $symbol], true);
    }

    public function getAllOrder($symbol)
    {
        return $this->makeRequest('get', '/fapi/v1/allOrders', ['symbol' => $symbol], true);
    }
    public function getTradeHistory($apiKey, $secretKey, $symbol)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $secretKey;
        return $this->makeRequest('get', '/fapi/v1/userTrades', ['symbol' => $symbol], true);
    }
}
