<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CryptoCurrency implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cryptoCurrencies = [
            'BTC',
            'ETH',
            'USDC',
            'USDT'
        ];

        if (!in_array($value, $cryptoCurrencies)) {
            $fail('The :attribute field is not a valid crypto currency');
        }
    }
}
