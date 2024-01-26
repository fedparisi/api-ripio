<?php

namespace App\Http\Controllers;

use Ripio;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreWithdrawalRequest;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Ripio::getWithdrawals(
            $request->only(
                'network_name',
                'status',
                'create_date_lte',
                'create_date_gte',
                'update_date_gte',
                'update_date_gte',
                'confirmation_date_lte',
                'confirmation_date_gte',
                'end_user_id',
                'currency_code_in',
            )
        );

        return response()->apiRipio(...$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWithdrawalRequest $request): JsonResponse
    {
        $validatedData = Arr::keysToCamelCase($request->validated());
        $withdrawalFee = Ripio::createWithdrawalFee(
            ...Arr::only($validatedData, ['currency', 'network', 'amount']),
            externalRef: $validatedData['withdrawalFeeExternalRef']
        );

        $withdrawal = Ripio::createWithdrawal(
            ...Arr::except($validatedData, 'withdrawalFeeExternalRef'),
            withdrawalFeeId: Arr::get($withdrawalFee, 'data.id')
        );

        return response()->apiRipio(...$withdrawal);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $withdrawalId): JsonResponse
    {
        $data = Ripio::getWithdrawal($withdrawalId);

        return response()->apiRipio(...$data);
    }
}
