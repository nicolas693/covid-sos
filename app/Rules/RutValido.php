<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RutValido implements Rule
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
        
        $rut = explode('-',$value)[0];
        $dv = strtoupper (explode('-',$value)[1]);
        $dvv = '';
        $rut_rev = strrev($rut); // se invierte el rut
        $multiplicador = 2; // setea el multiplicador de los digitos del rut
        $suma = 0;
        for ($i = 0; $i < strlen($rut_rev); $i++) { // itera hasta el largo del string $rut_rev
            $digito = $rut_rev[$i];
            $digito = intval($digito); // transforma el digito de string a int
            if ($multiplicador > 7) { // si el multiplicador es mayor a 7 se resetea a 2
                $multiplicador = 2;
            }
            $suma += $multiplicador * $digito; // se realiza la suma correspondiente
            $multiplicador += 1; //aumenta el multiplicador en 1 (max 7)
        }
        $valor = 11 * intval($suma / 11); // trunca la division entre la suma total y 11, además se multiplica por 11
        $resto = $suma - $valor; // del valor anteior se le resta a la suma total
        $final = 11 - $resto; // finalmente, se resta a 11 el resto obtenido.

        // si el valor final es 10 , el dv será k, si es 11 será 0, si es menor a 10 será el valor que represente.
        if ($final == 10) {
            $dvv =  "K";
        } elseif ($final == 11) {
            $dvv = "0";
        } else {
            $dvv= $final;
        }
        if($dv == $dvv){
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
        return 'Debe ingresar un RUT válido!';
    }
}
