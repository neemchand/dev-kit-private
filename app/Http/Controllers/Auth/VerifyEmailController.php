<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Auth;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmailController extends Controller
{
    use HttpResponse;

    public function __construct()
    {
        Auth::loginUsingId(request()->route('id'));
    }

    public function resend(EmailVerificationRequest $request): JsonResponse
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return $this->response([], __('messages.user.email_already_verified'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->sendEmailVerificationNotification();
        return $this->response(['status' => 'verification-link-sent'], __('messages.user.verification_link_sent'));
    }

    public function verify(EmailVerificationRequest $request, UrlGenerator $generator): RedirectResponse
    {
        $url = config('app.frontend_url');

        if (!$request->hasValidSignature()) {
            $path = config('frontend.verified_email_fail_redirect');

            if ($generator->hasCorrectSignature($request)) {
                $path .= "?{$this->getResendPath($request->route()->parameters())}";
            }
            return redirect("{$url}{$path}");
        }

        $path = config('frontend.verified_email_success_redirect');
        $user = $request->user();
        $param = Arr::query(['user_name' => $user->first_name]);
        $redirect = redirect()->intended($url . $path . "?$param");
        if ($request->query('no-redirect')) {
            $redirect = redirect()->back();
        }
        if ($user->hasVerifiedEmail()) {
            Auth::logout();

            return $redirect;
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        Auth::logout();

        return $redirect;
    }

    private function getResendPath(array $routeParams): string
    {
        $resend = URL::temporarySignedRoute(
            'verification.resend',
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $routeParams['id'],
                'hash' => $routeParams['hash'],
            ]
        );

        return Arr::query(['resend' => $resend]);
    }
}
