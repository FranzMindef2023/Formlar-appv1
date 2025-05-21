<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CiValido implements Rule
{
    public function passes($attribute, $value)
    {
        // Evita CIs como 000000, 111111, 123456, etc.
        if (preg_match('/^(.)\1{4,}$/', $value)) return false; // 00000, 11111
        if ($value === '123456' || $value === '654321') return false;

        return true;
    }

    public function message()
    {
        return 'El número de CI no parece válido.';
    }
}
