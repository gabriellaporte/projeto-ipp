<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HousePhoneRule implements Rule
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
      return strlen($value) == 14;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
      return 'O campo de :attribute é um número inválido.';
    }
}
