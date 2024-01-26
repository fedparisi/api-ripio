<?php

namespace App\Service\Exchange\Ripio;

use App\Models\ApiToken;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\ResponseInterface;
use App\Exceptions\InternalRipioException;
use App\Service\Exchange\Ripio\Resource\Auth;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Auth\AuthenticationException;
use App\Service\Exchange\Ripio\Resource\Resource;

class RipioClient
{
    use ApiUrl, ApiResponse;

    /** http verbs constants */
    const HTTP_GET = "get";
    const HTTP_POST = "post";
    const HTTP_PUT = "put";
    const HTTP_PATCH = "patch";
    const HTTP_DELETE = "delete";

    /** @var ApiToken $token */
    protected $token;

    /** @var PendingRequest $client */
    protected $client;

    public function __construct()
    {
        $this->token = ApiToken::getValidToken();
        $this->client = Http::acceptJson()->withResponseMiddleware([$this, 'throwIfApiHasErrors']);
    }

    /**
     * Make http request using the PendingRequest object.
     *
     * @param Resource $resource
     * @param string $method,
     * @param array $data
     * @return array
     */
    public function makeRequest(
        Resource $resource,
        string $method,
        array $data = [],
        array $routeParams = []
    ): array {
        $this->setToken();
        $url = $this->getUrl($resource, $routeParams);
        $response = $this->client->withToken($this->token->access_token)->{strtolower($method)}($url, $data);

        return $this->getResponse($response);
    }

    /**
     * Set authentication token if it is null or expired.
     *
     * @return void
     */
    protected function setToken(): void
    {
        if ($this->isExpiredToken()) {
            $response = $this->client->asForm()->post(
                $this->getUrl(Auth::Create),
                [
                    'grant_type' => 'client_credentials',
                    'client_id' => env('API_RIPIO_CLIENT_ID'),
                    'client_secret' => env('API_RIPIO_CLIENT_SECRET'),
                ]
            );

            throw_if(
                $response->status() === 401,
                AuthenticationException::class,
                'Invalid client_id / client_secret during token creation'
            );

            $data = $response->json();
            $this->token = ApiToken::create([
                ...Arr::only($data, ['access_token', 'expires_in']),
                'expires_in' => Carbon::now()->addSeconds($data['expires_in']),
            ]);
        }
    }

    /**
     * Check if the token object is expired or null.
     *
     * @return bool
     */
    protected function isExpiredToken(): bool
    {
        return is_null($this->token) ||
            Carbon::now()->gte(Carbon::createFromTimeString($this->token->expires_in));
    }

    /**
     * Throw an exception if the external api responds with an unexpected error (non json responds).
     * This method is used in the laravel http client respond middleware.
     *
     * @return ResponseInterface
     */
    public function throwIfApiHasErrors(ResponseInterface $response): ResponseInterface
    {
        $isJsonResponse = in_array("application/json", $response->getHeader("content-type"));

        throw_if(
            !$isJsonResponse && !in_array($response->getStatusCode(), [200, 201]),
            InternalRipioException::class,
            status: $response->getStatusCode()
        );

        return $response;
    }
}
