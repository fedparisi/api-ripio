<?php

namespace App\Service\Exchange\Ripio;

use App\Service\Exchange\Ripio\Resource\Transaction;

trait ApiTransaction
{
    use ApiUrl,
        ApiResponse;

    /**
     * List all executed transactions.
     *
     * @param array $queryParams
     * @return array
     */
    public function getTransactions(array $queryParams = []): array
    {
        return $this->client->makeRequest(
            Transaction::List,
            RipioClient::HTTP_GET,
            $queryParams
        );
    }

    /**
     * Retrieve transaction details given an id.
     *
     * @param string $transactionId
     * @return array
     */
    public function getTransaction(string $transactionId): array
    {
        return $this->client->makeRequest(
            Transaction::Retrieve,
            RipioClient::HTTP_GET,
            routeParams: ['transaction_id' => $transactionId]
        );
    }
}
