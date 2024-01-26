<?php

namespace App\Http\Controllers;

use Ripio;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WithdrawalFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Ripio::getWithdrawalFees(
            $request->only(
                'network',
                'create_date_lte',
                'create_date_gte',
                'currency_code_in'
            )
        );

        return response()->apiRipio(...$data);
    }
}
