<?php

namespace App\Service\Exchange\Ripio;

use App\Service\Exchange\Ripio\Resource\Withdrawal;
use App\Exceptions\InternalRipioException;

trait ApiWithdrawal
{
    use ApiUrl,
        ApiResponse;

    /**
     * Lists every withdrawal operation.
     *
     * @param array $queryParams
     * @return array
     */
    public function getWithdrawals(array $queryParams = []): array
    {
        return $this->client->makeRequest(
            Withdrawal::ListOrCreate,
            RipioClient::HTTP_GET,
            $queryParams
        );
    }

    /**
     * Retrieves a specific withdrawal given a withdrawal ID.
     *
     * @param string $withdrawalId
     * @return array
     */
    public function getWithdrawal(string $withdrawalId): array
    {
        return $this->client->makeRequest(
            Withdrawal::Retrieve,
            RipioClient::HTTP_GET,
            routeParams: ['withdrawal_id' => $withdrawalId]
        );
    }

    /**
     * Allows the creation of a withdrawal. It will debit from the end user's currency's balance and credit the amount in the destination address. The subtracted amount will also include a fee amount, returned as charged_fee on the response. If withdrawal_fee_id is provided, the operation will be executed with such fee, otherwise it will proceed with the fee needed to perform the transaction according to current blockchain activity.
     *
     * @param string $endUserId
     * @param string $currency
     * @param string $address
     * @param string $network
     * @param float $amount
     * @param string $externalRef
     * @param string $withdrawalFeeId
     * @param bool $throwException
     * @return array
     */
    public function createWithdrawal(
        string $endUserId,
        string $currency,
        string $address,
        string $network,
        float $amount,
        string $externalRef,
        string $withdrawalFeeId,
        bool $throwException = true
    ): array {
        $response = $this->client->makeRequest(
            Withdrawal::ListOrCreate,
            RipioClient::HTTP_POST,
            [
                'end_user' => $endUserId,
                'currency' => $currency,
                'address' => $address,
                'network' => $network,
                'amount' => $amount,
                'external_ref' => $externalRef,
                'withdrawal_fee' => $withdrawalFeeId,
            ]
        );

        throw_if(
            $throwException && $response['status'] !== 201,
            InternalRipioException::class,
            $response['message'] ?? 'The Withdrawal could not be created in the external Api Ripio',
            $response['status'],
            $response['data']
        );

        return $response;
    }
}
