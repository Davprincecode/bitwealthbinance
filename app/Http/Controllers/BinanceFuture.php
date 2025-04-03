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

    public function openOrders(Request $request)
    {
        $symbol = $request->get('symbol', 'BTCUSDT');
        return response()->json($this->binanceService->getOpenOrders($symbol));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'symbol' => 'required|string',
            'side' => 'required|string',
            'quantity' => 'required|numeric',
            'type' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        return response()->json($this->binanceService->placeOrder(
            $request->symbol,
            $request->side,
            $request->quantity,
            $request->type ?? 'MARKET',
            $request->price
        ));
    }

    public function positions()
    {
        return response()->json($this->binanceService->getPositions());
    }

    public function positionHistory(Request $request)
    {
        $symbol = $request->get('symbol', 'BTCUSDT');
        return response()->json($this->binanceService->getPositionHistory($symbol));
    }
}
