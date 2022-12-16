<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DateStringRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return strlen($value) == 10;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A data do campo de :attribute é inválida.';
    }
}
