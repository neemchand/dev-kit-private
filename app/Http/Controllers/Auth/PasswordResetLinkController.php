<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetLinkRequest;
use App\Services\PasswordResetService;
use App\Traits\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    use ActivityLog;

    public function store(PasswordResetLinkRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->activity(log: 'Password reset fail', properties: [
                'message' => __($status),
                'email' => $request->email,
            ]);
        }

        return response()->json(['status' => __('passwords.sent')]);
    }

    public function verify(Request $request, string $token_signature, PasswordResetService $service): RedirectResponse
    {
        $url = config('app.frontend_url');
        $pathSuccess = config('frontend.password_reset_success_redirect');
        $pathFail = config('frontend.password_reset_fail_redirect');
        $param = Arr::query(['email' => $request->email]);

        if (!$service->verify($request->email, $token_signature)) {
            return redirect("{$url}{$pathFail}?{$param}");
        }
        return redirect("{$url}{$pathSuccess}/{$token_signature}?{$param}");
    }
}
