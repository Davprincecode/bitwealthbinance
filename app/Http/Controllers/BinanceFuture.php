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

    public function openOrders($symbol)
    {

        return response()->json($this->binanceService->getOpenOrders($symbol));
    }

    public function positions()
    {
        return response()->json($this->binanceService->getPositions());
    }

    public function positionHistory($symbol)
    {
        return response()->json($this->binanceService->getPositionHistory($symbol));
    }
    public function positionAllOrder($symbol)
    {
        return response()->json($this->binanceService->getAllOrder($symbol));
    }
}
