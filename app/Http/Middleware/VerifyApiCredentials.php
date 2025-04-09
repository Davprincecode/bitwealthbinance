<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiCredentials
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log the headers to check if they are being received
    \Log::info('Incoming Headers:', $request->headers->all());
        dd($request->headers->all());

        $apiKey = $request->header('api_key');
        $secretKey = $request->header('secret_key');

        if (!$apiKey || !$secretKey) {
            return response()->json([
                'status' => false,
                'message' => 'API key and Secret key are required.'
            ], 401);
        }

        $request->merge(['api_key' => $apiKey, "secret_key" => $secretKey]);
        return $next($request);
    }
}
