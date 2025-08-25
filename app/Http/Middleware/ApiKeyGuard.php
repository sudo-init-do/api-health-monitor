<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyGuard
{
    public function handle(Request $request, Closure $next)
    {
        $provided = $request->header('X-API-Key');
        $expected = config('services.health.key');

        if (! $provided || ! hash_equals($expected, $provided)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
