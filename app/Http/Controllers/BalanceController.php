<?php

namespace App\Http\Controllers;

use Ripio;
use Illuminate\Http\JsonResponse;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $endUserId): JsonResponse
    {
        $data = Ripio::getBalances($endUserId);

        return response()->apiRipio(...$data);
    }
}
