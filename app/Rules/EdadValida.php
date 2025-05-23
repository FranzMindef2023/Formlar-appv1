<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class EdadValida implements Rule
{
    protected $min;
    protected $max;

    public function __construct($min = 17, $max = 22)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function passes($attribute, $value)
    {
        try {
            $fechaNacimiento = Carbon::parse($value);
            $edad = $fechaNacimiento->age;
            return $edad >= $this->min && $edad <= $this->max;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function message()
    {
        return "La edad debe estar entre {$this->min} y {$this->max} años.";
    }
}
