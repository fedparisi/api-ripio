<?php

namespace App\Service\Exchange\Ripio\Resource;

enum Deposit: string implements Resource
{
    case List = "/api/v1/deposits/";
    case Retrieve = "/api/v1/deposits/%s/";

    public function getValue(Resource $enum, array $routeParams = []): string
    {
        return match ($enum) {
            self::List => $enum->value,
            self::Retrieve => sprintf($enum->value, $routeParams['deposit_id']),
        };
    }
}
