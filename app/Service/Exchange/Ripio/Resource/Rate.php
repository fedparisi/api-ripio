<?php

namespace App\Service\Exchange\Ripio\Resource;

enum Rate: string implements Resource
{
    case List = "/api/v1/rates/";
    case ListHistorical = "/api/v1/markets/%s/historical-rates/";

    public function getValue(Resource $enum, array $routeParams = []): string
    {
        return match ($enum) {
            self::List => $enum->value,
            self::ListHistorical => sprintf($enum->value, $routeParams['pair']),
        };
    }
}
