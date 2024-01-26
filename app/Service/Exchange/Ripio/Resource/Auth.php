<?php

namespace App\Service\Exchange\Ripio\Resource;

enum Auth: string implements Resource
{
    case Create = "/oauth2/token/";

    public function getValue(Resource $enum, array $routeParams = []): string
    {
        return match ($enum) {
            self::Create => $enum->value,
        };
    }
}
