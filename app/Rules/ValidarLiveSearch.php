<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidarLiveSearch implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($cod)
    {
        $this->cod = $cod;
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
        //dd($this->cod,$value,substr($this->cod, 0, -1));
        $valores = substr($this->cod, 0, -1);
        $valores = explode(';', $valores);
        if(count($value)<=1){
            return false;
        }else{
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
        return 'Este campo es obligatorio!';
    }
}
