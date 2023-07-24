<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckLinkName implements Rule
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
        $check1 = strpos($value, 'http') !== false;
        $check2 = strpos($value, 'https') !== false;

        $check3 = '';
        $chars = str_split($value);
        foreach ($chars as $ch) {
            if ($ch >= 'a' && $ch <= 'z' || $ch >= 'A' && $ch <= 'Z' || $ch >= '0' && $ch <= '9') {
                $check3 = $check3.$ch;
            }
        }

        if(!$check1 && !$check2 && $check3 == $value){
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The url name should be characters or numbers';
    }
}
