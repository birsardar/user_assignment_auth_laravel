<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FullName implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the value contains at least one space and consists of alphabets
        return preg_match('/^[a-zA-Z ]+$/', $value) && strpos($value, ' ') !== false;
    }

    public function message()
    {
        return 'The :attribute must contain at least one space and consist of alphabets.';
    }
}
