<?php

namespace App\Http\Controllers;

use Ripio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Ripio::getDeposits(
            $request->only(
                'create_date_lte',
                'create_date_gte',
                'confirmation_date_lte',
                'confirmation_date_gte',
                'end_user_id',
                'currency_code_in',
                'page',
                'update_date_lte',
                'update_date_gte',
            )
        );

        return response()->apiRipio(...$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $depositId): JsonResponse
    {
        $data = Ripio::getDeposit($depositId);

        return response()->apiRipio(...$data);
    }
}
