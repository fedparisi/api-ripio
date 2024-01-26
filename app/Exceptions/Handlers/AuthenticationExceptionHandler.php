<?php

namespace App\Exceptions\Handlers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Exceptions\ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class AuthenticationExceptionHandler extends ExceptionHandler
{
    /**
     * Handle the AuthenticationException instance throwed by the Laravel Validator.
     *
     * @param AuthenticationException $e
     * @return ?JsonResponse
     */
    public function handle(Exception $e): ?JsonResponse
    {
        if ($this->request->is('api/*')) {
            return response()->apiRipio(
                null,
                SymfonyResponse::HTTP_UNAUTHORIZED,
                $e->getMessage()
            );
        }

        return null;
    }
}
