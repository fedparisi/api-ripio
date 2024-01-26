<?php

namespace App\Exceptions\Handlers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Exceptions\ExceptionHandler;
use App\Exceptions\InternalRipioException;

class InternalRipioExceptionHandler extends ExceptionHandler
{
    /**
     * Handle the InternalRipioException instance throwed by the Laravel Validator.
     *
     * @param InternalRipioException $e
     * @return ?JsonResponse
     */
    public function handle(Exception $e): ?JsonResponse
    {
        if ($this->request->is('api/*')) {
            return response()->apiRipio(
                $e->getData(),
                $e->getStatus(),
                $e->getMessage()
            );
        }

        return null;
    }
}
