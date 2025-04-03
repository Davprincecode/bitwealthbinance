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


        $this->apiKey = 'v83VOrFC6b1yq3tbdoGRMj7l0bYyGnb589z6MhA6L3z4nM9ejJGTCO2sfHhYK7qD';
        $this->apiSecret = '0jThJwNQBIu35cJtWAHulsTWrpD9PunGdAEi53nvBIxqd746eojx9EanBex1OFgO';
        $this->baseUrl = 'fapi.binance.com';
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
     * Place an Order
     */
    public function placeOrder($symbol, $side, $quantity, $type = "MARKET", $price = null)
    {
        $params = [
            'symbol' => $symbol,
            'side' => $side, // BUY or SELL
            'type' => $type, // MARKET, LIMIT, STOP_MARKET, etc.
            'quantity' => $quantity,
        ];

        if ($price && in_array($type, ['LIMIT', 'STOP_LIMIT'])) {
            $params['price'] = $price;
            $params['timeInForce'] = 'GTC'; // Good Till Canceled
        }

        return $this->makeRequest('post', '/fapi/v1/order', $params, true);
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
