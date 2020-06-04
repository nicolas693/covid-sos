<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesional;
use App\DocumentosProfesional;
use App\Asignacion;
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
        $profesional = Profesional::find($id);
        return view('modals/modalComplementar')->with('profesional',$profesional);
    }
}
