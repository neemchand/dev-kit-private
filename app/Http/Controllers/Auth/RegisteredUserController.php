<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Services\UserService;
use App\Traits\HttpResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use URL;

class RegisteredUserController extends Controller
{
    use HttpResponse;

    public function store(RegisterUserRequest $request): JsonResponse
    {
        $userService = new UserService();
        $user = $userService->register($request->safe()->toArray());

        $response = $this->response($user, __('messages.user.registered'), Response::HTTP_CREATED);
        if (app()->environment(['testing', 'local', 'staging'])) {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addHour(),
                ['id' => $user['id'], 'hash' => sha1($user['email']), 'no-redirect' => true],
            );
            $response->withCookie(new Cookie('verification_url', $verificationUrl));
        }
        return $response;
    }
}
