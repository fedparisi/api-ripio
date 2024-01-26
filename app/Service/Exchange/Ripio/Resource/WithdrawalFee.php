<?php

namespace App\Service\Exchange\Ripio\Resource;

enum WithdrawalFee: string implements Resource
{
    case ListOrCreate = "/api/v1/withdrawal-fees/";

    public function getValue(Resource $enum, array $routeParams = []): string
    {
        return match ($enum) {
            self::ListOrCreate => $enum->value,
        };
    }
}
