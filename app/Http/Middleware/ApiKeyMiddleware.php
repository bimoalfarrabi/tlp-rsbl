<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil key dari header, misal: X-API-KEY
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey || $apiKey !== env('API_KEY_TLP')) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}
