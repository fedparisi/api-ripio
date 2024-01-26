<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
abstract class ExceptionHandler
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Exception $e
     * @return JsonResponse|null
     */
    public function handle(Exception $e): ?JsonResponse
    {
        if ($this->request->is('api/*')) {
            return response()->apiRipio(
                $e,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }

        return null;
    }
}
