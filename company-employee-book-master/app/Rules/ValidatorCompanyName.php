<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidatorCompanyName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return preg_match('/^[\d\s\p{Cyrillic}a-zA-Z]+$/u',$value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please provide a valid Name without special symbols.';
    }
}
