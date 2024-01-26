<?php

namespace App\Service\Exchange\Ripio;

use App\Service\Exchange\Ripio\Resource\EndUser;

trait ApiUser
{
    /**
     * Fetch a list of all active End Users already created.
     *
     * @return array
     */
    public function getUsers(): array
    {
        return $this->client->makeRequest(
            EndUser::ListOrCreate,
            RipioClient::HTTP_GET
        );
    }

    /**
     * Retrieve end_user details given an end_user_id (external_ref).
     *
     * @param string $endUserId
     * @return array
     */
    public function getUser(string $endUserId): array
    {
        return $this->client->makeRequest(
            EndUser::Retrieve,
            RipioClient::HTTP_GET,
            routeParams: ['end_user_id' => $endUserId]
        );
    }

    /**
     * Create an End User wich represents the ultimate stakeholder that will be attached to all efective buy/sell trades. The partner will operate on-behalf-of the end user, serving as a middle-man for the quotation and trade execution process.
     * The partner must provide an unique and arbitrary ID (external_ref). All following trades will requiere this ID or REF in order to attach the trade data to that user.
     *
     * @param string $externalRef
     * @param bool $throwException
     * @return array
     */
    public function createUser(string $externalRef, bool $throwException = true): array
    {
        $response = $this->client->makeRequest(
            EndUser::ListOrCreate,
            RipioClient::HTTP_POST,
            ['external_ref' => $externalRef]
        );

        throw_if(
            $throwException && $response['status'] !== 201,
            InternalRipioException::class,
            $response['message'] ?? "The End User {$externalRef} could not be created in the external Api Ripio",
            $response['status'],
            $response['data']
        );

        return $response;
    }
}
