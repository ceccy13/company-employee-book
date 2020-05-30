<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidatorVatNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (preg_match('([A-Z0-9]{2}[B]{1}[0-9]{4}[^\w\sА-я/\\\b]{1}[A-Z0-9]{1}[0-2]{1})', $value) ||
        preg_match('/^[A-Z0-9]{3}[0-9]{5}[A-Z0-9]{1}[0-2]{1}$/', $value)) &&
        substr($value, 1, -8) != substr($value, 8, -1) &&
        substr($value, 0, -9) != substr($value, 8, -1);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please provide a valid VAT Number.';
    }
}
