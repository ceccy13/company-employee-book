<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidatorDate implements Rule
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
        return preg_match('/^(?:(\d{4})\-(\d{2})\-(\d{2}))$/', $value, $matches) &&
               checkdate((int)$matches[2], (int)$matches[3], (int)$matches[1]) == true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please provide a valid Date with Format yyyy-mm-dd.';
    }
}
