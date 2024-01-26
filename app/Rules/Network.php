<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Network implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $networks = [
            'BITCOIN',
            'ETHEREUM',
            'ETHEREUM_ROPSTEN',
            ...in_array(env('APP_ENV'), ['local', 'beta']) ? [
                'BITCOIN_TESTNET',
                'ETHEREUM_GOERLI',
            ] : []
        ];

        if (!in_array($value, $networks)) {
            $fail('The :attribute field is not a valid network');
        }
    }
}
