<?php

namespace App\Http\Controllers;

use App\Datos\Comuna;
use Illuminate\Http\Request;
use App\Profesional;
use App\ComunaPreferencia;
use App\Fecha;
use App\Datos\Pais;
use App\Datos\Titulo;
use App\Datos\Especialidad;
use App\Datos\Region;
use App\Datos\EstadoTitulo;
use App\Datos\Disponibilidad;
use App\Datos\ModalidadDisponibilidad;
use App\Rules\RutValido;
use App\Rules\ValidarLiveSearch;
use App\DocumentosProfesional;
use Auth;
use Validator, Redirect, Response, File;
use App\Document;

class ProfesionalController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('Roles:1')->only(['index','enviarSolicitud','obtenerProfesional','edit','update']);
    }

    public function index()
    {
        $region = new Region();
        $comunas = new Comuna();
        // TEST NUEVO REPO
        //$region->setConnection('masterdb');
        $region = $region->where('id', '!=', '0');
        $region = $region->pluck('tx_descripcion', 'id');
        $comunas = $comunas->where('id', '!=', '0');
        $comunas = $comunas->pluck('tx_descripcion', 'id');
        $estado_titulo = EstadoTitulo::orderBy('id', 'asc')->pluck('tx_descripcion', 'id')->toArray();
        $disponibilidad = Disponibilidad::select('id','tx_descripcion')->get();
        foreach($disponibilidad as $key => $d){
            $disponibilidad[$key]['modalidades'] = $disponibilidad[$key]->getModalidades();
        }
        
        return view('Profesional/profesional')->with('comunas',  $comunas)->with('regiones',  $region)->with('estado_titulo', $estado_titulo)->with('disponibilidad', $disponibilidad);
    }
    public function enviarSolicitud(Request $request)
    {

        $regLatino = '/^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$/';
        $regLatinoNum = '/^([A-Za-z0-9ÑñáéíóúÁÉÍÓÚ ]+)$/';
        $rut = '/^([0-9])+\-([kK0-9])+$/';
        $validatedData = $request->validate(
            [
                'extranjero' => 'required',
                'tipo_identificacion' => 'required',
                'rut' => ['required_if:tipo_identificacion,1', 'max:11', 'regex:' . $rut, new RutValido(request('rut')), 'nullable'],
                'provisorio' => ['required_if:tipo_identificacion,2', 'max:11', 'regex:' . $rut, new RutValido(request('rut')), 'nullable'],
                'pasaporte' => ['required_if:tipo_identificacion,3', 'max:11', 'regex:' . $regLatinoNum, 'nullable'],
                'nombre' => 'required|max:100|regex:' . $regLatino,
                'correo' => 'required|max:50|email',
                'telefono' => 'required|max:30',
                'direccion' => 'required|max:80|regex:' . $regLatinoNum,
                'profesion' => 'required|max:30',
                'comuna_residencia' => 'required|max:6',
                'comuna_preferencia' => ['required'],
                'profesion' => 'required|max:30',
                'especialidad' => 'required_if:profesion,32|max:30',
                'pais' => 'required_if:extranjero,1',
                'observacion' => 'max:190|regex:' . $regLatinoNum,
                'cert'      =>   'required|mimes:jpeg,png,jpg,bmp|max:2048',
                'cv'      =>   'required|mimes:pdf,docx|max:2048',
                'cedula'      =>   'required|mimes:jpeg,png,jpg,bmp|max:2048',
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'email' => 'El correo debe tener formato de correo electrónico!',
                'rut.regex' => 'El RUT debe ser ingresado sin puntos!',
                'rut.required_if' => 'Este campo es obligatorio!',
                'provisorio.required_if' => 'Este campo es obligatorio!',
                'pasaporte.required_if' => 'Este campo es obligatorio!',
                'provisorio.regex' => 'El RUT Provisorio debe ser ingresado sin puntos!',
                'nombre.regex' => 'Este campo solo debe contener letras y espacios!',
                'aPaterno.regex' => 'Este campo solo debe contener letras y espacios!',
                'aMaterno.regex' => 'Este campo solo debe contener letras y espacios!',
                'direccion.regex' => 'Este campo solo debe contener letras, números y espacios!',
                'especialidad.required_if' => 'Este campo es obligatorio si usted es Médico!',
                'pais.required_if' => 'Este campo es obligatorio si usted es extranjero!',
                'regiones.required_if' => 'Este campo es obligatorio si usted tiene disponibilidad!',
                'max' => 'Este campo no debe tener mas de :max caracteres !',
                'cedula.mimes' => 'Este archivo debe ser formato jpeg, png, jpg o bmp',
                'cert.mimes' => 'Este archivo debe ser formato jpeg, png, jpg o bmp',
                'cv.mimes' => 'Este archivo debe ser formato pdf, docx'
            ]
        );
        $d = $request->all();
        $d['fechas'] = json_decode($d['fechas']);


        $profesional = Profesional::where('rut', $d['rut'])->first();
        $profesional = null;
        if ($profesional == null) {
            $profesional = new Profesional();
            $profesional->rut = $d['rut'];
            $profesional->nombre = $d['nombre'];
            $profesional->email = $d['correo'];
            $profesional->telefono = $d['telefono'];
            $profesional->direccion = $d['direccion'];
            $profesional->tipo_profesional = $d['profesion'];
            $profesional->especialidad = $d['especialidad'];
            $profesional->tipo_identificacion = $d['tipo_identificacion'];
            $profesional->extranjero = $d['extranjero'];
            // $profesional->disponibilidad = $d['disponibilidad'];
            $profesional->comuna_residencia = $d['comuna_residencia'];
            $profesional->estado_titulo = $d['estudios'];
            if ($d['extranjero'] == '0') {
                $profesional->pais = '43';
            } else {
                $profesional->pais = $d['pais'];
            }
            $profesional->user_id = Auth::user()->id;

            $profesional->disponibilidad = $d['disponibilidad'];
            $profesional->modalidad = $d['modalidad'];

            $profesional->horas = $d['horas'];
            //dd($profesional,$d);
            $profesional->save();
            foreach ($d['comuna_preferencia'] as $key => $c) {
                $com = new ComunaPreferencia();
                $com->profesional_id = $profesional->id;
                $com->comuna_id = $c;
                $com->save();
            }

            foreach ($d['fechas'] as $key => $value) {
                $fecha = new Fecha();
                $fecha->profesional_id = $profesional->id;
                $fecha->dia = $d['fechas'][$key]->dia;
                $fecha->hora_inicio = $d['fechas'][$key]->hora_inicio;
                $fecha->hora_termino = $d['fechas'][$key]->hora_termino;
                $fecha->save();
            }
            // dd($d['fechas'],$d['horas']);
            $doc = new DocumentosProfesional();
            $doc->profesional_id = $profesional->id;

            $fileName = explode('-', $d['rut'])[0] . '_' . time() . '(CERT).' . $request->cert->extension();
            $request->cert->move(public_path('file'), $fileName);
            $doc->certificado_titulo = $fileName;

            $fileName = explode('-', $d['rut'])[0] . '_' . time() . '(CV).' . $request->cv->extension();
            $request->cv->move(public_path('file'), $fileName);
            $doc->curriculum = $fileName;

            $fileName = explode('-', $d['rut'])[0] . '_' . time() . '(CI).' . $request->cedula->extension();
            $request->cedula->move(public_path('file'), $fileName);
            $doc->cedula_identidad = $fileName;
            $doc->save();

            return redirect('/home')->with('status', 'created');
        } else {
            $profesional->save();

            // return redirect('/profesional')->with('status', 'updated');
            return redirect('Profesional/profesional');
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

    public function edit($id)
    {
        $profesional = Profesional::find($id);
        $region = new Region();
        $comunas = new Comuna();
        // TEST NUEVO REPO
        //$region->setConnection('masterdb');
        $region = $region->where('id', '!=', '0');
        $region = $region->pluck('tx_descripcion', 'id');
        $comunas = $comunas->where('id', '!=', '0');
        $comunas = $comunas->pluck('tx_descripcion', 'id');
        $estado_titulo = EstadoTitulo::orderBy('id', 'asc')->pluck('tx_descripcion', 'id')->toArray();
        return view('Profesional/edit')->with('comunas',  $comunas)->with('regiones',  $region)->with('estado_titulo', $estado_titulo)->with('profesional', $profesional);
    }

    public function update(Request $request)
    {
       
        $regLatino = '/^([A-Za-zÑñáéíóúÁÉÍÓÚ ]+)$/';
        $regLatinoNum = '/^([A-Za-z0-9ÑñáéíóúÁÉÍÓÚ ]+)$/';
        $rut = '/^([0-9])+\-([kK0-9])+$/';
        $validatedData = $request->validate(
            [
                'extranjero' => 'required',
                'tipo_identificacion' => 'required',
                'rut' => ['required_if:tipo_identificacion,1', 'max:11', 'regex:' . $rut, new RutValido(request('rut')), 'nullable'],
                'provisorio' => ['required_if:tipo_identificacion,2', 'max:11', 'regex:' . $rut, new RutValido(request('rut')), 'nullable'],
                'pasaporte' => ['required_if:tipo_identificacion,3', 'max:11', 'regex:' . $regLatinoNum, 'nullable'],
                'nombre' => 'required|max:100|regex:' . $regLatino,
                'correo' => 'required|max:50|email',
                'telefono' => 'required|max:30',
                'direccion' => 'required|max:80|regex:' . $regLatinoNum,
                'profesion' => 'required|max:30',
                'comuna_residencia' => 'required|max:6',
                'profesion' => 'required|max:30',
                'especialidad' => 'required_if:profesion,32|max:30',
                'pais' => 'required_if:extranjero,1'
            ],
            [
                'required' => 'Este campo es obligatorio!',
                'email' => 'El correo debe tener formato de correo electrónico!',
                'rut.regex' => 'El RUT debe ser ingresado sin puntos!',
                'rut.required_if' => 'Este campo es obligatorio!',
                'provisorio.required_if' => 'Este campo es obligatorio!',
                'pasaporte.required_if' => 'Este campo es obligatorio!',
                'provisorio.regex' => 'El RUT Provisorio debe ser ingresado sin puntos!',
                'nombre.regex' => 'Este campo solo debe contener letras y espacios!',
                'aPaterno.regex' => 'Este campo solo debe contener letras y espacios!',
                'aMaterno.regex' => 'Este campo solo debe contener letras y espacios!',
                'direccion.regex' => 'Este campo solo debe contener letras, números y espacios!',
                'especialidad.required_if' => 'Este campo es obligatorio si usted es Médico!',
                'pais.required_if' => 'Este campo es obligatorio si usted es extranjero!',
                'regiones.required_if' => 'Este campo es obligatorio si usted tiene disponibilidad!',
                'max' => 'Este campo no debe tener mas de :max caracteres !'
            ]
        );
        $datos = $request->all();
        $profesional = Profesional::find($datos['profesional_id']);
        $profesional->nombre = $datos['nombre'];
        $profesional->email = $datos['correo'];
        $profesional->telefono = $datos['telefono'];
        $profesional->direccion = $datos['direccion'];
        $profesional->tipo_profesional = $datos['profesion'];
        $profesional->especialidad = $datos['especialidad'];
        $profesional->tipo_identificacion = $datos['tipo_identificacion'];
        if($profesional->tipo_identificacion == 1){
            $profesional->rut = $datos['rut'];
        }elseif($profesional->tipo_identificacion == 2){
            $profesional->rut_provisorio = $datos['provisorio'];
        }elseif($profesional->tipo_identificacion == 3){
            $profesional->pasaporte = $datos['pasaporte'];
        }
        $profesional->extranjero = $datos['extranjero'];
        // $profesional->disponibilidad = $d['disponibilidad'];
        $profesional->comuna_residencia = $datos['comuna_residencia'];
        $profesional->estado_titulo = $datos['estudios'];
        if ($datos['extranjero'] == '0') {
            $profesional->pais = '43';
        } else {
            $profesional->pais = $datos['pais'];
        }

      
         $profesional->save();

         return view('/home')->with('status', 'updated');
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
