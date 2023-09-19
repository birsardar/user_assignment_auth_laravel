<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $api_key = $request->header('API_KEY');
        if ($api_key !== 'helloatg') {

            return response()->json([
                'status' => 0,
                'message' => 'Invalid API key',
                'data' => 'data',
            ]);
        }

        return $next($request);
    }
}
