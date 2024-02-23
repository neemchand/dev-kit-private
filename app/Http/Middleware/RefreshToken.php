<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use DateTime;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class RefreshToken
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $token = Auth::user()->currentAccessToken();
            if (is_null($token)) { // example: email verification route
                return $next($request);
            }

            if (get_class($token) === PersonalAccessToken::class) {
                $expiration = (new DateTime())->modify('+' . config('sanctum.expiration') . ' minutes');
                $token->expires_at = $expiration;
                $token->save();
            }
        }
        return $next($request);
    }
}
