<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Exceptions\ExceptionHandler;
use App\Exceptions\Handlers\ValidationExceptionHandler;
use App\Exceptions\Handlers\AuthenticationExceptionHandler;
use App\Exceptions\Handlers\InternalRipioExceptionHandler;

class HandlerWrapper
{
    /**
     * Array of exception handlers.
     */
    protected $handlers = [
        ValidationExceptionHandler::class,
        AuthenticationExceptionHandler::class,
        InternalRipioExceptionHandler::class,
    ];

    /**
     * Handle the Exception instance throwed by the Laravel Validator.
     *
     * @param Exception $e
     * @param Request $request
     */
    public function handle(Exception $e, Request $request)
    {
        $response = transform(
            $this->getHandler($e, $request),
            function (ExceptionHandler $handler) use ($e) {
                return $handler->handle($e);
            }
        );

        if (!is_null($response)) {
            return $response;
        }
    }

    /**
     * Returns the exception handler.
     *
     * @param Exception $e
     * @param Request $request
     */
    protected function getHandler(Exception $e, Request $request): ?ExceptionHandler
    {
        $handler = __NAMESPACE__ . "\\Handlers\\" . class_basename($e) . "Handler";

        return in_array($handler, $this->handlers, true) ? App::make($handler, [$request]) : null;
    }
}
