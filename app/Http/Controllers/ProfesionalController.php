<?php

namespace App\Http\Controllers;

use App\Datos\Comuna;
use Illuminate\Http\Request;
use App\Profesional;
use App\ComunaPreferencia;
use App\Fecha;
use App\ColaCallCenter;
use App\Datos\Pais;
use App\Datos\Titulo;
use App\Datos\Especialidad;
use App\Datos\Region;
use App\Datos\EstadoTitulo;
use App\Datos\Disponibilidad;
use App\Datos\ModalidadDisponibilidad;
use App\Datos\PosGrado;
use App\Rules\RutValido;
use App\Rules\ValidarLiveSearch;
use App\DocumentosProfesional;
use Auth;
use DateTime;
use Validator, Redirect, Response, File;
use App\Document;

class ProfesionalController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('Roles:1')->only(['index', 'enviarSolicitud', 'obtenerProfesional', 'edit', 'update']);
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
        $disponibilidad = Disponibilidad::select('id', 'tx_descripcion')->get();
        $postgrado = PosGrado::pluck('tx_descripcion', 'id')->toArray();
        foreach ($disponibilidad as $key => $d) {
            $disponibilidad[$key]['modalidades'] = $disponibilidad[$key]->getModalidades();
        }

        return view('Profesional/profesional')->with('comunas',  $comunas)
            ->with('regiones',  $region)
            ->with('estado_titulo', $estado_titulo)
            ->with('disponibilidad', $disponibilidad)
            ->with('postgrado', $postgrado);
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
                'observaciones' => ['max:190', 'regex:' . $regLatinoNum, 'nullable'],
                'cert'      =>   'mimes:jpeg,png,jpg,bmp|max:2048',
                'cv'      =>   'required|mimes:pdf,docx,doc|max:2048',
                'cedula'      =>   'required|mimes:jpeg,png,jpg,bmp|max:2048',
                'capacitacion'      =>   'mimes:jpeg,png,jpg,bmp,pdf|max:2048'
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
                'cv.mimes' => 'Este archivo debe ser formato pdf, docx',
                'capacitacion.mimes' => 'Este archivo debe ser formato jpeg, png, jpg, bmp o pdf',
            ]
        );
        $datos = $request->all();
        $datos['fechas'] = json_decode($datos['fechas']);

        $actual = ColaCallCenter::where('indice', '1')->first();
        $siguiente =  ColaCallCenter::where('lugar_cola', $actual->lugar_cola + 1)->first();
        if($siguiente == null){
            $siguiente =  ColaCallCenter::where('lugar_cola', 1)->first();
        }

        $profesional = Profesional::where('rut', $datos['rut'])->first();
        $profesional = null;
        if ($profesional == null) {
            $profesional = new Profesional();
            $profesional->rut = $datos['rut'];
            $profesional->nombre = $datos['nombre'];
            $profesional->email = $datos['correo'];
            $profesional->telefono = $datos['telefono'];
            $profesional->direccion = $datos['direccion'];
            $profesional->tipo_profesional = $datos['profesion'];
            $profesional->especialidad = $datos['especialidad'];
            $profesional->tipo_identificacion = $datos['tipo_identificacion'];
            $profesional->extranjero = $datos['extranjero'];
            // $profesional->disponibilidad = $datos['disponibilidad'];
            $profesional->comuna_residencia = $datos['comuna_residencia'];
            $profesional->estado_titulo = $datos['estudios'];
            $profesional->postgrado = $datos['postgrado'];
            if ($datos['extranjero'] == '0') {
                $profesional->pais = '43';
            } else {
                $profesional->pais = $datos['pais'];
            }
            $profesional->user_id = Auth::user()->id;

            $profesional->disponibilidad = $datos['disponibilidad'];
            $profesional->modalidad = $datos['modalidad'];

            $profesional->horas = $datos['horas'];
            //dd($profesional,$d);
            $profesional->observaciones = $datos['observaciones'];

            $profesional->callcenter_id = $siguiente->user_id;
            $actual->indice = 0;
            $actual->save();
            $siguiente->indice = 1;
            $siguiente->save();

            $profesional->save();
            foreach ($datos['comuna_preferencia'] as $key => $c) {
                $com = new ComunaPreferencia();
                $com->profesional_id = $profesional->id;
                $com->comuna_id = $c;
                $com->save();
            }

            foreach ($datos['fechas'] as $key => $value) {
                $fecha = new Fecha();
                $fecha->profesional_id = $profesional->id;
                $fecha->dia = $datos['fechas'][$key]->dia;
                $fecha->hora_inicio = $datos['fechas'][$key]->hora_inicio;
                $fecha->hora_termino = $datos['fechas'][$key]->hora_termino;
                $fecha->save();
            }
            // dd($datos['fechas'],$datos['horas']);
            $doc = new DocumentosProfesional();
            $doc->profesional_id = $profesional->id;
        

            $fecha = new DateTime();
            $time = $fecha->format('Y-m-d His');
    
         
            if (isset($datos['cert'])) {
                
                $fileName = explode('-', $datos['rut'])[0] . '_' .  $time . '(CERT).' . $request->cert->extension();
                $request->cert->move(public_path('file'), $fileName);
                $doc->certificado_titulo = $fileName;
            }
    
            if (isset($datos['cv'])) {
               
                $fileName = explode('-', $datos['rut'])[0] . '_' .  $time . '(CV).' . $request->cv->extension();
                $request->cv->move(public_path('file'), $fileName);
                $doc->curriculum = $fileName;
            }
    
    
            if (isset($datos['cedula'])) {
               
                $fileName = explode('-', $datos['rut'])[0] . '_' .  $time . '(CI).' . $request->cedula->extension();
                $request->cedula->move(public_path('file'), $fileName);
                $doc->cedula_identidad = $fileName;
            }
    
            if (isset($datos['capacitacion'])) {
                
                $fileName = explode('-', $datos['rut'])[0] . '_' .  $time . '(CAP).' . $request->capacitacion->extension();
                $request->capacitacion->move(public_path('file'), $fileName);
                $doc->capacitacion = $fileName;
            }
    

            $doc->save();

            return redirect('/home')->with('status', 'created')->with('message', 'creado');
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
        $comunas_pref = new ComunaPreferencia();
        // TEST NUEVO REPO
        //$region->setConnection('masterdb');
        $region = $region->where('id', '!=', '0');
        $region = $region->pluck('tx_descripcion', 'id');
        $comunas = $comunas->where('id', '!=', '0');
        $comunas = $comunas->pluck('tx_descripcion', 'id');
        $comunas_pref = $comunas_pref->where('profesional_id', $profesional->id)->pluck('comuna_id')->toArray();
        $estado_titulo = EstadoTitulo::orderBy('id', 'asc')->pluck('tx_descripcion', 'id')->toArray();
        $disponibilidad = Disponibilidad::select('id', 'tx_descripcion')->get();
        $postgrado = PosGrado::pluck('tx_descripcion', 'id')->toArray();
        $fechas = Fecha::where('profesional_id', $profesional->id)->get();
        foreach ($disponibilidad as $key => $d) {
            $disponibilidad[$key]['modalidades'] = $disponibilidad[$key]->getModalidades();
        }
        return view('Profesional/edit')->with('comunas',  $comunas)
            ->with('regiones',  $region)
            ->with('estado_titulo', $estado_titulo)
            ->with('profesional', $profesional)
            ->with('disponibilidad', $disponibilidad)
            ->with('comunas_pref', $comunas_pref)
            ->with('fechas', $fechas)
            ->with('postgrado', $postgrado);
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
                'observaciones' => ['max:190', 'regex:' . $regLatinoNum, 'nullable'],
                'pais' => 'required_if:extranjero,1',
                'cert'      =>   'mimes:jpeg,png,jpg,bmp|max:2048',
                'cv'      =>   'mimes:pdf,docx|max:2048',
                'cedula'      =>   'mimes:jpeg,png,jpg,bmp|max:2048',
                'capacitacion'      =>   'mimes:jpeg,png,jpg,bmp,pdf|max:2048',
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
                'cv.mimes' => 'Este archivo debe ser formato pdf, docx',
                'capacitacion.mimes' => 'Este archivo debe ser formato jpeg, png, jpg, bmp o pdf'
            ]
        );

        $datos = $request->all();

        $datos['fechas'] = json_decode($datos['fechas'], true);
        foreach ($datos['fechas'] as $key => $f) {
            $datos['fechas'][$key] = join('-', $f);
        }
        $datos['fechas'] = array_unique($datos['fechas']);
        foreach ($datos['fechas'] as $key => $f) {
            $datos['fechas'][$key] = explode('-', $f);
        }


        //dd($datos);
        $profesional = Profesional::find($datos['profesional_id']);
        $profesional->nombre = $datos['nombre'];
        $profesional->email = $datos['correo'];
        $profesional->telefono = $datos['telefono'];
        $profesional->direccion = $datos['direccion'];
        $profesional->tipo_profesional = $datos['profesion'];
        $profesional->especialidad = $datos['especialidad'];
        $profesional->tipo_identificacion = $datos['tipo_identificacion'];
        if ($profesional->tipo_identificacion == 1) {
            $profesional->rut = $datos['rut'];
        } elseif ($profesional->tipo_identificacion == 2) {
            $profesional->rut_provisorio = $datos['provisorio'];
        } elseif ($profesional->tipo_identificacion == 3) {
            $profesional->pasaporte = $datos['pasaporte'];
        }
        $profesional->extranjero = $datos['extranjero'];
        // $profesional->disponibilidad = $datos['disponibilidad'];
        $profesional->comuna_residencia = $datos['comuna_residencia'];
        $profesional->estado_titulo = $datos['estudios'];
        $profesional->postgrado = $datos['postgrado'];
        $profesional->observaciones = $datos['observaciones'];
        if ($datos['extranjero'] == '0') {
            $profesional->pais = '43';
        } else {
            $profesional->pais = $datos['pais'];
        }
        $profesional->user_id = Auth::user()->id;

        $profesional->disponibilidad = $datos['disponibilidad'];
        $profesional->modalidad = $datos['modalidad'];

        $profesional->horas = $datos['horas'];
        //dd($profesional,$datos);
        Fecha::where('profesional_id', $profesional->id)->delete();
        foreach ($datos['fechas'] as $key => $value) {
            $fecha = new Fecha();
            $fecha->profesional_id = $profesional->id;
            $fecha->dia = $value[0];
            $fecha->hora_inicio = $value[1];
            $fecha->hora_termino = $value[2];
            $fecha->save();
        }
        //$profesional->save();
        $comunas_preferencia = array_keys($profesional->getComunasPreferencia());
        foreach ($comunas_preferencia as $key => $cp) {
            $com = ComunaPreferencia::where('profesional_id', $profesional->id)->where('comuna_id', $cp)->first();
            $com->delete();
        }

        foreach ($datos['comuna_preferencia'] as $key => $c) {
            $com = new ComunaPreferencia();
            $com->profesional_id = $profesional->id;
            $com->comuna_id = $c;
            $com->save();
        }

        //dd($datos, $datos['horas']);

        $doc = DocumentosProfesional::where('profesional_id', $datos['profesional_id'])->orderBy('created_at', 'desc')->first();
        $doc = $doc->replicate();
        $doc->profesional_id = $profesional->id;
        $fecha = new DateTime();
        $time = $fecha->format('Y-m-d His');

        $ct_docs = 0;
        if (isset($datos['cert'])) {
            $ct_docs++;
            $fileName = explode('-', $datos['rut'])[0] . '_' .  $time . '(CERT).' . $request->cert->extension();
            $request->cert->move(public_path('file'), $fileName);
            $doc->certificado_titulo = $fileName;
        }

        if (isset($datos['cv'])) {
            $ct_docs++;
            $fileName = explode('-', $datos['rut'])[0] . '_' .  $time . '(CV).' . $request->cv->extension();
            $request->cv->move(public_path('file'), $fileName);
            $doc->curriculum = $fileName;
        }


        if (isset($datos['cedula'])) {
            $ct_docs++;
            $fileName = explode('-', $datos['rut'])[0] . '_' .  $time . '(CI).' . $request->cedula->extension();
            $request->cedula->move(public_path('file'), $fileName);
            $doc->cedula_identidad = $fileName;
        }

        if (isset($datos['capacitacion'])) {
            $ct_docs++;
            $fileName = explode('-', $datos['rut'])[0] . '_' .  $time . '(CAP).' . $request->capacitacion->extension();
            $request->capacitacion->move(public_path('file'), $fileName);
            $doc->capacitacion = $fileName;
        }

        if ($ct_docs > 0) {
            $doc->save();
        }
        $profesional->save();

        return redirect('/home')->with('message', 'actualizado');
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
