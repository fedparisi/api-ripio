<?php

namespace App\Http\Requests;

use App\Rules\CryptoCurrency;
use App\Rules\Network;
use Illuminate\Foundation\Http\FormRequest;

class StoreWithdrawalRequest extends FormRequest
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
            'end_user_id' => 'required|string|alpha_dash|max:250',
            'currency' => [
                'required',
                'string',
                new CryptoCurrency,
            ],
            'address' => 'required|string',
            'network' => [
                'required',
                'string',
                new Network,
            ],
            'amount' => 'required|decimal:2,8|gt:0',
            'external_ref' => 'required|string|max:250',
            'withdrawal_fee_external_ref' => 'required|string|max:250',
        ];
    }
}
