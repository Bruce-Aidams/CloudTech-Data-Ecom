<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GhanaPhoneValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove spaces, dashes, and other formatting
        $cleaned = preg_replace('/[\s\-\(\)]+/', '', $value);

        // Check if it's a valid Ghana phone number
        // Ghana phone numbers: 10 digits starting with 0
        // Valid prefixes: 020, 023, 024, 025, 026, 027, 028, 050, 054, 055, 056, 057, 059

        // Pattern: 0 + (20|23|24|25|26|27|28|50|53|54|55|56|57|59) + 7 digits
        $pattern = '/^0(20|23|24|25|26|27|28|50|53|54|55|56|57|59)\d{7}$/';

        if (!preg_match($pattern, $cleaned)) {
            $fail('The :attribute must be a valid Ghana phone number (e.g., 0241234567, 0501234567).');
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be a valid Ghana phone number.';
    }
}
