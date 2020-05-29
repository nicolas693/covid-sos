<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesional;
use App\Datos\Pais;
use App\Datos\Titulo;
use App\Datos\Especialidad;
use App\Datos\Region;
use App\Rules\RutValido;

class ProfesionalController extends Controller
{
    public function index()
    {
        $region = new Region();
        //$region->setConnection('masterdb');
        $region = $region->where('id', '!=', '0');
        $regiones = $region->pluck('tx_descripcion', 'id');
        return view('profesional')->with('regiones', $regiones);
    }
    public function enviarSolicitud(Request $request)
    {


        $regLatino = '/^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$/';
        $regLatinoNum = '/^([A-Za-z0-9ÑñáéíóúÁÉÍÓÚ ]+)$/';
        $rut = '/^([0-9])+\-([kK0-9])+$/';
        $validatedData = $request->validate(
            [
                'rut' => ['required', 'max:11', 'regex:' . $rut, new RutValido(request('rut'))],
                'nombre' => 'required|max:100|regex:' . $regLatino,
                'correo' => 'required|max:50|email',
                'telefono' => 'required|max:30',
                'lugar_trabajo' => 'required|max:80|regex:' . $regLatinoNum,
                'profesion' => 'required|max:30',
                'especialidad' => 'required_if:profesion,32|max:30',
                'pais' => 'required',
                'regiones' => 'required_if:disponibilidad,si',
                'observacion' => 'max:190|regex:' . $regLatinoNum,
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
                'regiones.required_if' => 'Este campo es requerido si usted tiene disponibilidad!',
                'max' => 'Este campo no debe tener mas de :max caracteres !'
            ]
        );
        $d = $request->all();
        $d['fechas'] = json_decode($d['fechas']);
        $profesional = Profesional::where('rut', $d['rut'])->first();
        if ($profesional == null) {
            $profesional = new Profesional();
            $profesional->rut = $d['rut'];
            $profesional->nombre = $d['nombre'];
            $profesional->email = $d['correo'];
            $profesional->telefono = $d['telefono'];
            $profesional->lugar_trabajo = $d['lugar_trabajo'];
            $profesional->tipo_profesional = $d['profesion'];
            $profesional->especialidad = $d['especialidad'];
            $profesional->disponibilidad = $d['disponibilidad'];
            $profesional->pais = $d['pais'];
            $profesional->save();
            return redirect('/profesional')->with('status', 'created');
        } else {
            $profesional->rut = $d['rut'];
            $profesional->nombre = $d['nombre'];
            $profesional->email = $d['correo'];
            $profesional->telefono = $d['telefono'];
            $profesional->lugar_trabajo = $d['lugar_trabajo'];
            $profesional->tipo_profesional = $d['profesion'];
            $profesional->especialidad = $d['especialidad'];
            $profesional->pais = $d['pais'];
            $profesional->disponibilidad = $d['disponibilidad'];
            $profesional->save();
            return redirect('/profesional')->with('status', 'updated');
        }
    }
    public function obtenerProfesional($rut)
    {
        $profesional = Profesional::where('rut', $rut)->first();
        if ($profesional == null) {

            return 'vacio';
        } else {
            $pais = new Pais();
            //$pais->setConnection('masterdb');

            $titulo = new Titulo();
            //$titulo->setConnection('masterdb');

            $especialidad = new Especialidad();
            //$especialidad->setConnection('masterdb');

            $profesional['tx_pais'] = $pais->where('id', $profesional->pais)->first()->tx_descripcion;
            $profesional['tx_tp'] = $titulo->where('id', $profesional->tipo_profesional)->first()->tx_descripcion;
            $profesional['tx_es'] = $especialidad->where('id', $profesional->especialidad)->first()->tx_descripcion;
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
