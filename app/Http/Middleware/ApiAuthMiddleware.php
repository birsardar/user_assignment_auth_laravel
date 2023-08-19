<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->header('API_KEY') !== 'helloatg') {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid API key',
            ]);
        }

        return $next($request);
    }
}
