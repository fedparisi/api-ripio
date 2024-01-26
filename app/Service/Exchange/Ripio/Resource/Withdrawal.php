<?php

namespace App\Service\Exchange\Ripio\Resource;

enum Withdrawal: string implements Resource
{
    case ListOrCreate = "/api/v1/withdrawals/";
    case Retrieve = "/api/v1/withdrawals/%s/";

    public function getValue(Resource $enum, array $routeParams = []): string
    {
        return match ($enum) {
            self::ListOrCreate => $enum->value,
            self::Retrieve => sprintf($enum->value, $routeParams['withdrawal_id']),
        };
    }
}
