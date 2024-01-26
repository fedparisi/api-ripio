<?php

namespace App\Service\Exchange\Ripio;

use App\Service\Exchange\Ripio\Resource\Rate;

trait ApiRate
{
    use ApiUrl,
        ApiResponse;

    /**
     * An exchange rate is the rate at which one currency will be exchanged for another currency.
     * Returns last market rates (BUY and SELL) for each account pair enabled.
     *
     * @return array
     */
    public function getRates(): array
    {
        return $this->client->makeRequest(
            Rate::List,
            RipioClient::HTTP_GET
        );
    }

    /**
     * Returns historical market rates, for a given enabled pair.
     *
     * @return array
     */
    public function getHistoricalRates(string $pair): array
    {
        return $this->client->makeRequest(
            Rate::ListHistorical,
            RipioClient::HTTP_GET,
            routeParams: ['historical_rates' => $pair]
        );
    }
}
