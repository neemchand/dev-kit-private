<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetLinkRequest;
use App\Models\User;
use App\ValueObjects\Admin\NotificationVO;
use App\Notifications\ResetPassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('forgot-password');
    }

    public function store(PasswordResetLinkRequest $request): RedirectResponse
    {
        ResetPassword::createUrlUsing(function (User $notifiable, string $token) {
            return url(
                route(
                    'admin.password.reset',
                    ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()]
                )
            );
        });

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect(route('admin.login'))->with(
                'notification',
                new NotificationVO(
                    NotificationEnum::SUCCESS,
                    __('messages.notification.success'),
                    __($status)
                )
            )
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
