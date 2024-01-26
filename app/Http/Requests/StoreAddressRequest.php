<?php

namespace App\Http\Requests;

use App\Rules\Network;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'network' => [
                'required',
                'string',
                new Network,
            ],
            'address_type' => [
                'string',
                Rule::in(['DEFAULT', 'LEGACY', 'SEGWIT']),
            ],
        ];
    }
}
