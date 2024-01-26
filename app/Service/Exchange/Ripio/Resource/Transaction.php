<?php

namespace App\Service\Exchange\Ripio\Resource;

enum Transaction: string implements Resource
{
    case List = "/api/v1/transactions/";
    case Retrieve = "/api/v1/transactions/%s/";
    case ListOrCreateResuableQuote = "/api/v1/reusable-quotes/";
    case ExecuteResuableQuote = "/api/v1/reusable-quotes/%s/actions/execute/";

    public function getValue(Resource $enum, array $routeParams = []): string
    {
        return match ($enum) {
            self::List,
            self::ListOrCreateResuableQuote => $enum->value,
            self::Retrieve => sprintf($enum->value, $routeParams['transaction_id']),
            self::ExecuteResuableQuote => sprintf($enum->value, $routeParams['reusable_quote_id']),
        };
    }
}
