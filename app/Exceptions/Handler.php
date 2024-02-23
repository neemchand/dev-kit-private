<?php

namespace App\Exceptions;

use Exception;
use App\Traits\RestExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Log;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    use RestExceptionHandler;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            Log::info($e->getMessage());
        });

        $this->renderable(function (ThrottleRequestsException $e) {
            return response()->json(['message' => __('messages.error.too_many_attempts')], Response::HTTP_TOO_MANY_REQUESTS);
        });

        $this->renderable(function (AccessDeniedHttpException $e) {
            return response()->json(['message' => __('messages.error.access_denied')], Response::HTTP_FORBIDDEN);
        });
    }
}
