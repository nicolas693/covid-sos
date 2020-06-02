<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesional;
use DB;

class CallCenterController extends Controller
{
    public function index(){
        $estado_titulo=DB::table('estado_titulos')->pluck('tx_descripcion','id')->toArray();
        $especialidad=DB::table('gen_especialidad_medica')->pluck('tx_descripcion','cd_especialidad_medica')->toArray();
        $profesion=DB::table('gen_titulo_profesional')->pluck('tx_descripcion','cd_tipo_profesional')->toArray();
        $comunas=DB::table('gen_comuna')->pluck('tx_descripcion','id')->toArray();

        $profesionales = Profesional::all();

        return view('/callcenter')->with('profesionales',$profesionales);
    }
    public function verInfo($id){
        $profesional = Profesional::find($id);
        return view('modals/modalInfo')->with('profesional',$profesional);
    }
    public function asignarProfesional($id){
        $profesional = Profesional::find($id);
        return view('modals/modalAsignacion')->with('profesional',$profesional);
    }
}
