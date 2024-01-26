<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Ripio;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $endUserId): JsonResponse
    {
        $data = Ripio::getAddresses($endUserId);

        return response()->apiRipio(...$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request): JsonResponse
    {
        $validatedData = Arr::keysToCamelCase($request->validated());
        $data = Ripio::createAddress(...$validatedData);

        return response()->apiRipio(...$data);
    }
}
