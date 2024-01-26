<?php

namespace App\Service\Exchange\Ripio;

use App\Service\Exchange\Ripio\Resource\Resource;

trait ApiUrl
{
    /**
     * Get the URL for each end-point in the external API Ripio.
     *
     * @param Resource $resource
     * @return string
     */
    public function getUrl(Resource $resource, array $routeParams = []): string
    {
        return rtrim(env('API_RIPIO_URL_BASE'), '/') . $resource->getValue($resource, $routeParams);
    }
}
