<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        // For APIs we usually return 401 JSON; only redirect if it's a web request.
        if (! $request->expectsJson()) {
            // If you don't have a login route, you can return null here.
            return route('login', absolute: false) ?? '/login';
        }
        return null;
    }
}
