<?php

namespace App\Service\Exchange\Ripio;

use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Pipeline;
use App\Exceptions\InternalRipioException;
use App\Service\Exchange\Ripio\Resource\EndUser;

trait ApiAddress
{
    /**
     * Returns a list of the given user's wallet's addresses.
     *
     * @param string $endUserId
     * @return array
     */
    public function getAddresses(string $endUserId): array
    {
        return $this->client->makeRequest(
            EndUser::ListOrCreateAddresses,
            RipioClient::HTTP_GET,
            routeParams: ['end_user_id' => $endUserId]
        );
    }

    /**
     * Create an address and optionally a wallet for an end user in the ripio api.
     *
     * @param string $network
     * @param string $endUserId
     * @param string $addressType
     * @return array
     */
    public function createAddress(
        string $network,
        string $endUserId,
        string $addressType = "DEFAULT"
    ): array {
        $endUserExternalRef = Pipeline::send($endUserId)
            ->through(
                function (string $endUserId, Closure $next) {
                    $response = $this->getUser($endUserId);

                    if (!in_array($response['status'], [200, 404])) {
                        throw new InternalRipioException(
                            "An error ocurred while obtaining the EndUser {$endUserId} from external Api Ripio",
                            $response['status'],
                            $response['data']
                        );
                    }

                    return $next(Arr::get($response, 'data.external_ref'));
                }
            )
            ->then(function (?string $externalRef) use ($endUserId) {
                if (is_null($externalRef)) {
                    $response = $this->createUser($endUserId);
                    $externalRef = Arr::get($response, 'data.external_ref');
                }

                return $externalRef;
            });

        $response = $this->client->makeRequest(
            EndUser::ListOrCreateAddresses,
            RipioClient::HTTP_POST,
            [
                'network' => $network,
                'address_type' => $addressType,
            ],
            ['end_user_id' => $endUserExternalRef]
        );

        return $response;
    }
}
