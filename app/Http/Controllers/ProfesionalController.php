<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesional;

class ProfesionalController extends Controller
{
    public function enviarSolicitud(Request $request){
        

        $regLatino = '/^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$/';
        $regLatinoNum = '/^([A-Za-z0-9ÑñáéíóúÁÉÍÓÚ ]+)$/';
        $rut = '/^([0-9])+\-([kK0-9])+$/';
        $validatedData = $request->validate(
            [
                'rut' => 'required|max:11|regex:' . $rut,
                'nombre' => 'required|max:30|regex:' . $regLatino,
                'aPaterno' => 'required|max:30|regex:' . $regLatino,
                'aMaterno' => 'required|max:30|regex:' . $regLatino,
                'correo' => 'required|max:50|email',
                'telefono' => 'required|max:30',
                'direccion' => 'required|max:80|regex:' . $regLatinoNum,
                'tipoProfesional' => 'required|max:30',
                'especialidad' => 'required_if:tipoProfesional,medico|max:30',
                'pais' => 'required'
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'email' => 'El correo debe tener formato de correo electrónico!',
                'rut.regex' => 'El RUT debe ser ingresado sin puntos!',
                'nombre.regex' => 'Este campo solo debe contener letras y espacios!',
                'aPaterno.regex' => 'Este campo solo debe contener letras y espacios!',
                'aMaterno.regex' => 'Este campo solo debe contener letras y espacios!',
                'direccion.regex' => 'Este campo solo debe contener letras, números y espacios!',
                'especialidad.required_if' => 'Este campo es requerido si usted es Médico!',
                'max' => 'Este campo no debe tener mas de :max caracteres !'
            ]
        );
        $d = $request->all();
        $profesional = new Profesional();
        $profesional->rut = $d['rut'];
        $profesional->nombre = $d['nombre'];
        $profesional->apellido_paterno = $d['aPaterno'];
        $profesional->apellido_materno = $d['aMaterno'];
        $profesional->email = $d['correo'];
        $profesional->telefono = $d['telefono'];
        $profesional->direccion = $d['direccion'];
        $profesional->tipo_profesional = $d['tipoProfesional'];
        $profesional->especialidad = $d['especialidad'];
        $profesional->pais = $d['pais'];
        $profesional->save();

        return view('/profesional');
        
    }
    public function obtenerProfesional($rut){
        $profesional = Profesional::where('rut',$rut)->first();
        if($profesional==null){
            return 'vacio';
        }else{
            return $profesional;
        }
        
    }

    private  function calcularDv($rut)
    {
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
            return "K";
        } elseif ($final == 11) {
            return "0";
        } else {
            return $final;
        }
    }
}
