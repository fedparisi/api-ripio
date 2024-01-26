<?php

namespace App\Http\Controllers;

use Ripio;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = Ripio::getUsers();

        return response()->apiRipio(...$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = Ripio::createUser($request->validated('external_ref'), false);

        return response()->apiRipio(...$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $endUserId): JsonResponse
    {
        $data = Ripio::getUser($endUserId);

        return response()->apiRipio(...$data);
    }
}
