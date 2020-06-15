<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;
use Hash;

class ValidarPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
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
        

        $hashedPassword = User::find($this->id)->password;
       
        if (Hash::check($value, $hashedPassword)) {
           return true;
        }else{
           return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Esta password no conincide con nuestros registros!';
    }
}
