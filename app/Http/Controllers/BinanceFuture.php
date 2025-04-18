<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BinanceFuturesService;

class BinanceFuture extends Controller
{
    protected $binanceService;

    public function __construct(BinanceFuturesService $binanceService)
    {
        $this->binanceService = $binanceService;
    }

    public function openOrders($apiKey, $secretKey, $symbol)
    {
    try {
        return response()->json($this->binanceService->getOpenOrders($apiKey, $secretKey, $symbol));
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
    }

    public function positions($apiKey, $secretKey)
    {
        try {
        return response()->json($this->binanceService->getPositions($apiKey, $secretKey));

    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
    }



    public function tradeHistory($apiKey, $secretKey, $symbol)
    {
        try {
        return response()->json($this->binanceService->getTradeHistory($apiKey, $secretKey, $symbol));
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
    }




// =====================================================
    public function positionHistory($symbol)
    {
        return response()->json($this->binanceService->getPositionHistory($symbol));
    }
    public function positionAllOrder($symbol)
    {
        return response()->json($this->binanceService->getAllOrder($symbol));
    }
}
