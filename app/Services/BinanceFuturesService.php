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
        $this->baseUrl = 'fapi.binance.com';
        $this->apiKey = 'nZCT8PkhJL7mQloPeE1velhBEf2GIl0peF6qn7BnJoyWKy1d6i74nRAqgOIfnVEi';
        $this->apiSecret = 'y6Web7GZX5t7pffasRRtmJO1H6UU5dDGfctFIVUEjmWey0UNcOZOYQS04NK1rziW';
        // $this->apiKey = '1c9c2e1837b75f91ee5bbd0b3d15ef5571868946644c8a0da5ed2e8d461fbb1c';
        // $this->apiSecret = '38dc061581dfb14a693b61eaa4d637e1de0c98129635f2c672b5f993a6ec3d2b';
        // $this->baseUrl = "https://testnet.binancefuture.com";
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
    public function getOpenOrders($symbol)
    {
        return $this->makeRequest('get', '/fapi/v1/openOrders', ['symbol' => $symbol], true);
    }


    /**
     * Get Open Positions
     */
    public function getPositions()
    {
        return $this->makeRequest('get', '/fapi/v2/positionRisk', [], true);
    }

    /**
     * Get Position History (Account Trades)
     */
    public function getPositionHistory($symbol)
    {
        return $this->makeRequest('get', '/fapi/v1/userTrades', ['symbol' => $symbol], true);
    }
}
