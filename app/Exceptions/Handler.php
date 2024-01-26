<?php

namespace App\Exceptions;

use Throwable;
use App\Exceptions\HandlerWrapper;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
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
     * @var HandlerWrapper
     */
    protected $handlerWrapper;

    /**
     * Create a new class instance.
     *
     * @param Container $container
     * @param HandlerWrapper $handler
     * @return void
     */
    public function __construct(
        Container $container,
        HandlerWrapper $handlerWrapper
    ) {
        $this->handlerWrapper = $handlerWrapper;
        parent::__construct($container);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable([$this->handlerWrapper, "handle"]);
    }
}
