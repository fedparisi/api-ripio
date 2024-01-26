<?php

namespace App\Http\Requests;

use App\Rules\Pair;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class StoreReusableQuoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // ReusableQuote
            'pair' => [
                'required',
                'string',
                new Pair,
            ],
            'external_ref' => 'required|string',
            // ReusableQuoteExecution
            'execution_external_ref' => 'nullable|string',
            'end_user_id' => 'required_with:execution_external_ref|string|alpha_dash|max:250',
            'op_type' =>[
                'required_with:execution_external_ref',
                'string',
                Rule::in([
                    'BUY',
                    'SELL',
                ]),
            ],
            'base_amount' => 'required_if:op_type,BUY|decimal:2,8|gt:0',
            'quote_amount' => 'required_if:op_type,SELL|integer',
        ];
    }
}
