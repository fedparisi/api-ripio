<?php

namespace App\Service\Exchange\Ripio\Resource;

enum EndUser: string implements Resource
{
    case ListOrCreate = "/api/v1/end-users/";
    case Retrieve = "/api/v1/end-users/%s/";
    case ListBalances = "/api/v1/end-users/%s/balances/";
    case ListOrCreateAddresses = "/api/v1/end-users/%s/addresses/";

    public function getValue(Resource $enum, array $routeParams = []): string
    {
        return match ($enum) {
            self::ListOrCreate => $enum->value,
            self::Retrieve,
            self::ListBalances,
            self::ListOrCreateAddresses => sprintf($enum->value, $routeParams['end_user_id']),
        };
    }
}
