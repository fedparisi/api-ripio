<?php

namespace App\Service\Exchange\Ripio;

use App\Exceptions\InternalRipioException;
use App\Service\Exchange\Ripio\Resource\Transaction;

trait ApiReusableQuote
{
    use ApiUrl,
        ApiResponse;

    /**
     * Retrieve a paginated list of generated reusable quotes.
     *
     * @param array $queryParams
     * @return array
     */
    public function getReusableQuotes(array $queryParams = []): array
    {
        return $this->client->makeRequest(
            Transaction::ListOrCreateResuableQuote,
            RipioClient::HTTP_GET,
            $queryParams
        );
    }

    /**
     * ReusableQuotes are "held rates" offered by Ripio to buy or sell assets at a specific price within a period of time - for example, the option to buy ETH within the next 30 seconds for $10,000.
     *
     * @param string $pair
     * @param string $externalRef
     * @param bool $throwException
     * @return array
     */
    public function createReusableQuote(
        string $pair,
        string $externalRef,
        bool $throwException = true
    ): array
    {
        $response = $this->client->makeRequest(
            Transaction::ListOrCreateResuableQuote,
            RipioClient::HTTP_POST,
            [
                'pair' => $pair,
                'external_ref' => $externalRef,
            ]
        );

        throw_if(
            $throwException && $response['status'] !== 201,
            InternalRipioException::class,
            $response['message'] ?? 'The Reusable Quote could not be created in the external Api Ripio',
            $response['status'],
            $response['data']
        );

        return $response;
    }


    /**
     * Reusable Quote Executions buy or sell assets using a Reusable Quote obtained from the Reusable Quote Creation flow.
     * The asset, and guaranteed price/rate of the execution are specified by the reusable quote with ID reusable_quote_id.
     *
     * @param string $reusableQuoteId
     * @param string $endUserId
     * @param string $opType
     * @param string $executionExternalRef
     * @param float|null $baseAmount
     * @param float|null $quoteAmount
     * @param bool $throwException
     * @return array
     */
    public function executionReusableQuote(
        string $reusableQuoteId,
        string $endUserId,
        string $opType,
        string $executionExternalRef,
        ?float $baseAmount = null,
        ?float $quoteAmount = null,
        bool $throwException = true
    ): array
    {
        $response = $this->client->makeRequest(
            Transaction::ExecuteResuableQuote,
            RipioClient::HTTP_POST,
            [
                'reusable_quote_id' => $reusableQuoteId,
                'end_user_id' => $endUserId,
                'op_type' => $opType,
                'external_ref' => $executionExternalRef,
                ...($baseAmount ? ['base_amount' => $baseAmount] : []),
                ...($quoteAmount ? ['quote_amount' => $quoteAmount] : []),
            ],
            [
                'reusable_quote_id' => $reusableQuoteId
            ]
        );

        throw_if(
            $throwException && $response['status'] !== 201,
            InternalRipioException::class,
            $response['message'] ?? 'The Transaction could not be created in the external Api Ripio',
            $response['status'],
            $response['data']
        );

        return $response;
    }
}
