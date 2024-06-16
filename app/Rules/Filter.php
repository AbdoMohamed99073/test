<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Filter implements ValidationRule
{
    protected $forbidden;
    

    public function __construct($forbidden)
    {
        $this->forbidden = $forbidden;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
            if(in_array(strtolower($value) , $this->forbidden))
            {
                $fail('This name is forbidden');
            }
    }
}