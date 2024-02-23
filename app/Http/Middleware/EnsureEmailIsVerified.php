<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            ! $request->user()
            || ($request->user() instanceof MustVerifyEmail
            && ! $request->user()->hasVerifiedEmail())
        ) {
            if ($request->hasSession()) {
                Auth::logout();
                return response()->redirectToRoute('admin.login')
                    ->withErrors(['email' => __('messages.user.email_not_verified')]);
            }
            return response()->json(['message' => __('messages.user.email_not_verified')], 403);
        }

        return $next($request);
    }
}
