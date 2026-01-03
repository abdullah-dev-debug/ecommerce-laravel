<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authentication
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $guard = 'web'): Response
    {
        if (!Auth::guard($guard)->check()) {
            return $this->unauthenticated($request, $guard);
        }

        return $next($request);
    }
    
    /**
     * Handle unauthenticated requests.
     */
    protected function unauthenticated(Request $request, string $guard): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        
        $loginRoutes = [
            'admin' => 'admin.login',
            'vendor' => 'vendor.login',
            'web' => 'login',
            'customer' => 'login',
        ];
        
        $route = $loginRoutes[$guard] ?? 'login';
        
        return redirect()->route($route)->withErrors([
            'email' => 'Please login to access this page.',
        ]);
    }
}