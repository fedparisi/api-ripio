<?php

namespace App\Service\Exchange\Ripio;

use Illuminate\Http\Client\Response;

trait ApiResponse
{
    /**
     * @param Response $response
     * @return array
     */
    public function getResponse(Response $response): array
    {
        $data = $response->json();

        return [
            'data' => $data,
            'message' => $data['detail']['message'] ?? null,
            'status' =>  $response->status(),
        ];
    }
}
