<?php

namespace App\Http\Middleware;


use App\Enums\UserRole;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ApiAuthMiddleware extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $user = Auth::guard('api')->user();

        if (!$user || $user->role != UserRole::ADMIN) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
