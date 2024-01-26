<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class InternalRipioException extends Exception
{
    /**
     * The status code to use for the response.
     *
     * @var int
     */
    protected $status;

    /**
     * The exception data provided from de external api Ripio.
     *
     * @var array
     */
    protected $data;

    public function __construct(
        string $message = "An error ocurred in the external Api Ripio",
        int $status = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR,
        ?array $data = null
    ) {
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * Returns the http status code.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Returns the exception data.
     *
     * @return array
     */
    public function getData(): ?array
    {
        return $this->data;
    }
}
