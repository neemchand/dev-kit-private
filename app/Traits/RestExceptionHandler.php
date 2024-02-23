<?php

namespace App\Traits;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\{MethodNotAllowedHttpException, NotFoundHttpException, HttpException};

/**
 * @codeCoverageIgnore
 */
trait RestExceptionHandler
{
    protected Throwable $exception;

    protected function getJsonResponseForException(Throwable $exception): JsonResponse
    {
        $this->exception = $exception;
        switch (true) {
            case ($this->exception instanceof AuthenticationException):
                return $this->unauthenticate();
            case ($this->exception instanceof ValidationException):
                return $this->validation();

            case ($this->exception instanceof MethodNotAllowedHttpException):
                return $this->MethodNotAllowedHttp();

            case ($this->exception instanceof NotFoundHttpException):
            case ($this->exception instanceof ModelNotFoundException):
                return $this->NotFoundHttp();

            case ($this->exception instanceof HttpException):
                if ($this->exception->getStatusCode() >= 500) {
                    return $this->serverError();
                }
                return $this->httpException();

            default:
                return $this->serverError();
        }
    }

    protected function validation(): JsonResponse
    {
        return $this->response(
            __('messages.validation_error'),
            400,
            $this->exception->validator->errors()->getMessages()
        );
    }

    protected function methodNotAllowedHttp(): JsonResponse
    {
        return $this->response(__('method_not_allowed'), 404, $this->exception->getMessage());
    }

    protected function notFoundHttp(): JsonResponse
    {
        return $this->response(__('not_found'), 404, $this->exception->getMessage());
    }

    protected function invalidHeaders(): JsonResponse
    {
        return $this->response(__('invalid_headers'), 400);
    }

    protected function invalidToken(): JsonResponse
    {
        return $this->response(__('invalid_token'), 404);
    }

    protected function response($message, $http_code, $data = ''): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => $message,
                'data' => $data
            ],
            $http_code
        );
    }

    protected function httpException(): JsonResponse
    {
        return $this->response($this->exception->getMessage(), $this->exception->getStatusCode());
    }

    protected function serverError(): JsonResponse
    {
        return $this->response(__('not_found'), 500, $this->exception->getMessage());
    }

    protected function unauthenticate(): JsonResponse
    {
        return $this->response(__('not_found'), 401, $this->exception->getMessage());
    }
}
