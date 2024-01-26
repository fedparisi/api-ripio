<?php

namespace App\Service\Exchange\Ripio;

use App\Service\Exchange\Ripio\Resource\Deposit;

trait ApiDeposit
{
    use ApiResponse;

    /**
     * List all the deposits received.
     *
     * @param array $queryParams
     * @return array
     */
    public function getDeposits(array $queryParams = []): array
    {
        return $this->client->makeRequest(
            Deposit::List,
            RipioClient::HTTP_GET,
            $queryParams
        );
    }

    /**
     * Retrieves details of a received deposit by id.
     *
     * @param string $depositId
     * @return array
     */
    public function getDeposit(string $depositId): array
    {
        return $this->client->makeRequest(
            Deposit::Retrieve,
            RipioClient::HTTP_GET,
            routeParams: ['deposit_id' => $depositId]
        );
    }
}
