<?php

namespace App\Http\Controllers;

use Ripio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Ripio::getTransactions(
            $request->only(
                'op_type',
                'date_gt',
                'date_lt',
                'end_user'
            )
        );

        return response()->apiRipio(...$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $transactionId): JsonResponse
    {
        $data = Ripio::getTransaction($transactionId);

        return response()->apiRipio(...$data);
    }
}
