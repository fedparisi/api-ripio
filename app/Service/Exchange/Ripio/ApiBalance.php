<?php

namespace App\Service\Exchange\Ripio;

use App\Service\Exchange\Ripio\Resource\EndUser;

trait ApiBalance
{
    /**
     * Retrieve end_user balances details given an end_user_id (external_ref).
     *
     * @param string $endUserId
     * @return array
     */
    public function getBalances(string $endUserId): array
    {
        return $this->client->makeRequest(
            EndUser::ListBalances,
            RipioClient::HTTP_GET,
            routeParams: ["end_user_id" => $endUserId]
        );
    }
}
