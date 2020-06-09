<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesional;
use App\DocumentosProfesional;
use App\Asignacion;
use App\Complementario;
use App\Experiencia;
use DB;

class CallCenterController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('Roles:3')->only(['index','verInfo','asignarProfesional']);
    }

    public function index()
    {
        $estado_titulo = DB::table('estado_titulos')->pluck('tx_descripcion', 'id')->toArray();
        $especialidad = DB::table('gen_especialidad_medica')->pluck('tx_descripcion', 'cd_especialidad_medica')->toArray();
        $profesion = DB::table('gen_titulo_profesional')->pluck('tx_descripcion', 'cd_tipo_profesional')->toArray();
        $comunas = DB::table('gen_comuna')->pluck('tx_descripcion', 'id')->toArray();


        $profesionales = Profesional::all();

        return view('/callcenter')->with('profesionales', $profesionales);
    }
    public function verInfo($id)
    {
        $profesional = Profesional::find($id);
        $documentos = DocumentosProfesional::where('profesional_id', $id)->first();

        $tiene_doc = 0;
        $tiene_cv = 0;
        $tiene_ci = 0;
        $tiene_cert = 0;
        if ($documentos != null) {
            $tiene_doc = 1;
            if ($documentos->curriculum != null) {
                $tiene_cv = 1;
            }
            if ($documentos->cedula_identidad != null) {
                $tiene_ci = 1;
            }
            if ($documentos->certificado_titulo != null) {
                $tiene_cert = 1;
            }
        }

        //ultima asignacion
        $asignacion=Asignacion::where('profesional_id', $profesional->id)->orderBy('created_at', 'desc')->first();

        return view('modals/modalInfo')->with('profesional', $profesional)
            ->with('tiene_doc', $tiene_doc)
            ->with('tiene_cv', $tiene_cv)
            ->with('tiene_ci', $tiene_ci)
            ->with('tiene_cert', $tiene_cert)
            ->with('asignacion',$asignacion);
    }
    public function asignarProfesional($id){
        $profesional = Profesional::find($id);
        return view('modals/modalAsignacion')->with('profesional',$profesional);
    }

    public function complementarProfesional($id){

        $complementario=Complementario::where('profesional_id',$id)->first();
        if(isset($complementario)){
            // dd($comple);
            $profesional = Profesional::find($id);
            return view('modals/modalComplementar')->with('profesional',$profesional)->with('complementario',$complementario);
        }else{
            $profesional = Profesional::find($id);
            return view('modals/modalComplementar')->with('profesional',$profesional);
        }
    }
    public function complementarProfesionalEnviar(Request $request){

         //dd(json_decode($request->experiencias, true), $request->all(),$request->observaciones);

        $expeOld=Experiencia::where('profesional_id',$request->profesional_id);

        $expCallcenter=json_decode($request->experiencias, true);
        foreach ($expCallcenter as $key => $exp) {
            $expeNew=new Experiencia();
            $expeNew->profesional_id=$request->profesional_id;
            $expeNew->tiempoTipo=$exp["tiempoTipo"];
            $expeNew->tiempoPeriodo=$exp["tiempoPeriodo"];
            $expeNew->servicioClinico=$exp["servicioClinico"];
            $expeNew->lugarTrabajo=$exp["lugarTrabajo"];
            $expeNew->save();
        }

       // dd(json_decode($request->experiencias, true), $request->all(),$request->observaciones);

        //$expeNew=new Experiencia();

        $comple=new Complementario();
        $comple->profesional_id=$request->profesional_id;
        $comple->eunacom=$request->eunacom;
        $comple->conacem=$request->conacem;
        $comple->supersalud=$request->supersalud;
        $comple->observaciones=$request->observaciones;
        $comple->iaas=$request->iaas;
        $comple->iaasCurso=$request->iaas;
        $comple->rcp=$request->rcp;
        $comple->rcpCurso=$request->rcpCurso;
        $comple->pacienteCritico=$request->pacienteCritico;
        $comple->pacienteCriticoCurso=$request->pacienteCriticoCurso;
        $comple->ventilacionMecanica=$request->ventilacion;
        $comple->ventilacionMecanicaCurso=$request->ventilacionCurso;
        $comple->adminEstado=$request->adminEstado;
        $comple->adminEstadoCurso=$request->adminEstadoCurso;
        $comple->urgenciaDesastres=$request->urgenciaDesastres;
        $comple->urgenciaDesastresCurso=$request->urgenciaDesastresCurso;
        $comple->adultoMayor=$request->adultoMayor;
        $comple->adultoMayorCurso=$request->adultoMayorCurso;
        $comple->infeccionesRespiratorias=$request->infeccionesRespiratorias;
        $comple->infeccionesRespiratoriasCurso=$request->infeccionesRespiratoriasCurso;
        $comple->ira=$request->ira;
        $comple->iraCurso=$request->iraCurso;
        $comple->era=$request->era;
        $comple->eraCurso=$request->eraCurso;
        $comple->covid19=$request->covid19;
        $comple->covid19Curso=$request->covid19Curso;
        $comple->otro=$request->otro;
        $comple->otroCurso=$request->otroCurso;
        $comple->save();

        return redirect('/callcenter')->with('status','complementario');
    }
}
