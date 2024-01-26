<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as SymfonyHttpResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('apiRipio', $this->getApiResponseCallable());
        Arr::macro('keysToCamelCase', $this->getKeysToCamelCaseCallable());
    }

    /**
     * Return a callable added at runtime into the Response service.
     * The returned function is used in all endpoints to respond requests.
     *
     * @return callable
     */
    protected function getApiResponseCallable(): callable
    {
        return function (
            mixed $data = null,
            int $status = SymfonyHttpResponse::HTTP_OK,
            ?string $message = null
        ): JsonResponse {
            $message = $message ?? SymfonyHttpResponse::$statusTexts[$status];
            $response = transform($data, function ($data) {
                if ($data instanceof JsonResource) {
                    return $data->response()->getData(true);
                }

                return $data;
            });

            return Response::json([
                'data' => $response,
                'message' => $message,
                'status' => $status
            ])->setStatusCode($status);
        };
    }

    /**
     * Return a callable added at runtime into the Arr helper class.
     * The returned function is used to trasnform array keys to camelCase format.
     *
     * @return callable
     */
    protected function getKeysToCamelCaseCallable(): callable
    {
        return function (array $data): array {
            return Arr::mapWithKeys(
                $data,
                function (?string $value, string $key) {
                    return [Str::camel($key) => $value];
                }
            );
        };
    }
}
