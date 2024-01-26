<?php

namespace App\Exceptions\Handlers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Exceptions\ExceptionHandler;
use Illuminate\Validation\ValidationException;

class ValidationExceptionHandler extends ExceptionHandler
{
    /**
     * Handle the ValidationException instance throwed by the Laravel Validator.
     *
     * @param ValidationException $e
     * @return ?JsonResponse
     */
    public function handle(Exception $e): ?JsonResponse
    {
        if ($this->request->is('api/*')) {
            return response()->apiRipio(
                $e->errors(),
                $e->status,
                $e->getMessage()
            );
        }

        return null;
    }
}
