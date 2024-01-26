<?php

namespace App\Http\Controllers;

use Ripio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Ripio::getRates();

        return response()->apiRipio(...$data);
    }

    /**
     * @param Request $request
     * @param string $pair
     * @return JsonResponse
     */
    public function getHistoricalRates(Request $request, string $pair): JsonResponse
    {
        $data = Ripio::getHistoricalRates($pair);

        return response()->apiRipio(...$data);
    }
}
