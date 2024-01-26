<?php

namespace App\Service\Exchange\Ripio;

use App\Service\Exchange\Ripio\Resource\WithdrawalFee;

trait ApiWithdrawalFee
{
    use ApiUrl,
        ApiResponse;

    /**
     * Lists every withdrawal fees.
     *
     * @param array $queryParams
     * @return array
     */
    public function getWithdrawalFees(array $queryParams = []): array
    {
        return $this->client->makeRequest(
            WithdrawalFee::ListOrCreate,
            RipioClient::HTTP_GET,
            $queryParams
        );
    }

    /**
     * Cretae a withdrawal fee.
     * Withdrawal fees are "held fees" to withdraw assets at a specific fee within a period of time.
     * For example, the option to transfer out 0.25 ETH within the next 15 seconds for 0.001 ETH.
     *
     * @param string $currency
     * @param string $network
     * @param float $amount
     * @param string $externalRef
     * @param bool $throwException
     * @return array
     */
    public function createWithdrawalFee(
        string $currency,
        string $network,
        float $amount,
        string $externalRef,
        bool $throwException = true
    ): array {
        $response = $this->client->makeRequest(
            WithdrawalFee::ListOrCreate,
            RipioClient::HTTP_POST,
            [
                'currency' => $currency,
                'network' => $network,
                'amount' => $amount,
                'external_ref' => $externalRef,
            ]
        );

        throw_if(
            $throwException && $response['status'] !== 201,
            InternalRipioException::class,
            $response['message'] ?? 'The Withdrawal Fee could not be created in the external Api Ripio',
            $response['status'],
            $response['data']
        );

        return $response;
    }
}
