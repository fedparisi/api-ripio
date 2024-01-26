<?php

namespace App\Http\Controllers;

use Ripio;
use App\Http\Requests\StoreReusableQuoteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ReusableQuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Ripio::getReusableQuotes(
            $request->only('pair', 'date_gt')
        );

        return response()->apiRipio(...$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReusableQuoteRequest $request)
    {
        $validatedData = Arr::keysToCamelCase($request->validated());
        $reusableQuote = Ripio::createReusableQuote(
            ...Arr::only($validatedData, ['pair', 'externalRef'])
        );

        // reusable quote execution if external_ref is present
        $data = !empty($validatedData['executionExternalRef']) ?
            Ripio::executionReusableQuote(
                Arr::get($reusableQuote, 'data.id'),
                ...Arr::except($validatedData, ['pair', 'externalRef'])
            ) : $reusableQuote;

        return response()->apiRipio(...$data);
    }
}
