<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Pair implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pairs = [
            'BTC_ARS',
            'ETH_ARS',
            'USDT_ARS',
            'USDC_ARS',
        ];

        if (!in_array($value, $pairs)) {
            $fail('The :attribute field is not a valid pair name');
        }
    }
}
