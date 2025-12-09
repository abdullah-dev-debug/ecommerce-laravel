<?php

namespace App\Http\Middleware;

use App\Utils\AppUtils;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class Api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          $token = $request->header('X-BROWSER-TOKEN') ?: $request->cookie(env('APP_TOKEN'));
        if (!$token) {
            return AppUtils::ErrorResponse('Unauthorized: Token missing', 401);
        }

        if (!Cache::has('api_token_' . $token)) {
            return AppUtils::ErrorResponse('Unauthorized: Invalid token', 401);
        }

        return $next($request);
    }
}
