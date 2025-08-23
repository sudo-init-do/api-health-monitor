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

        abort_unless($provided && hash_equals($expected, $provided), 401, 'Unauthorized');
        return $next($request);
    }
}
