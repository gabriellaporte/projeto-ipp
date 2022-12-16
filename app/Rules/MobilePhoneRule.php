<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MobilePhoneRule implements Rule
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
        return strlen($value) == 16;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O campo do :attribute é um número de celular inválido. Lembre-se de colocar o \'9\' antes do número.';
    }
}
