<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesional;
use App\Datos\Posgrado;
use App\Datos\Titulo;
use App\Datos\ServicioClinico;
use App\Datos\Especialidad;
use App\Datos\Capacitacion;
use App\SolicitudCapacitacion;
use App\SolicitudServicio;
use App\Solicitud;
use App\SolicitudEliminada;

class ReclutadorController extends Controller
{
    public function index(){
        $solicitudes = Solicitud::all();
        // $capacitaciones=Capacitacion::all();
        // $postgrado= Posgrado::all();
        // $titulos= Titulo::all()->pluck('id','tx_descripcion');
        // $servicioClinico= ServicioClinico::where('cd_tipo_atencion','A')
        //                                 ->orWhere('cd_tipo_atencion','HD')
        //                                 ->orWhere('cd_tipo_atencion','AC')
        //                                 ->orWhere('cd_tipo_atencion','PA')
        //                                 ->orWhere('cd_tipo_atencion','H')
        //                                 ->orWhere('cd_tipo_atencion','U')
        //                                 ->get();
        // $especialidades= Especialidad::all();

        return view('/reclutador')
            // ->with('profesional',$profesional)
            // ->with('postgrado',$postgrado)
            // ->with('titulos',$titulos)
            // ->with('servicioClinico',$servicioClinico)
            // ->with('especialidades',$especialidades)
            // ->with('capacitaciones',$capacitaciones)
            ->with('solicitudes',$solicitudes);
    }

    public function crearSolicitud(Request $request){

    //    dd($request->all());

        $request['fecha_inicio']= str_replace("/","-",$request->inicio);
        $request['fecha_termino']= str_replace("/","-",$request->termino);
        // dd( $request->all());

        $solicitud=Solicitud::create($request->all());
        $solicitud->save();
        // dd($solicitud);

        if(isset($request->capacitaciones)){
            foreach ($request->capacitaciones as $key => $capacitacion) {
                $cap=new SolicitudCapacitacion();
                $cap->solicitud_id=$solicitud->id;
                $cap->capacitacion_id=$capacitacion;
                $cap->save();
            }
        }

        if(isset($request->experiencia_servicio)){
            foreach ($request->experiencia_servicio as $key => $servicio) {
                $ser=new SolicitudServicio();
                $ser->solicitud_id=$solicitud->id;
                $ser->servicio_id=$servicio;
                $ser->save();
            }
        }

        return redirect('/reclutador')->with('status','solicitud_creada');
    }

    public function verSolicitud($id){
        $solicitud = Solicitud::find($id);
        $capacitacionesTodas=Capacitacion::all();
        $capacitaciones = SolicitudCapacitacion::where('solicitud_id',$id)->pluck( 'capacitacion_id')->toJson();
        $servicios = SolicitudServicio::where('solicitud_id',$id)->pluck('servicio_id')->toJson();
        $servicioClinico= ServicioClinico::where('cd_tipo_atencion','A')
                                            ->orWhere('cd_tipo_atencion','HD')
                                            ->orWhere('cd_tipo_atencion','AC')
                                            ->orWhere('cd_tipo_atencion','PA')
                                            ->orWhere('cd_tipo_atencion','H')
                                            ->orWhere('cd_tipo_atencion','U')
                                            ->get();
        return view('modals/modalVerSolicitud')
            ->with('solicitud', $solicitud)
            ->with('capacitaciones', $capacitaciones)
            ->with('servicios', $servicios)
            ->with('servicioClinico',$servicioClinico)
            ->with('capacitacionesTodas',$capacitacionesTodas);
    }

    public function nuevaSolicitud(){
        $capacitaciones=Capacitacion::all();
        $postgrado= Posgrado::all();
        $titulos= Titulo::all()->pluck('id','tx_descripcion');
        $servicioClinico= ServicioClinico::where('cd_tipo_atencion','A')
                                        ->orWhere('cd_tipo_atencion','HD')
                                        ->orWhere('cd_tipo_atencion','AC')
                                        ->orWhere('cd_tipo_atencion','PA')
                                        ->orWhere('cd_tipo_atencion','H')
                                        ->orWhere('cd_tipo_atencion','U')
                                        ->get();
        $especialidades= Especialidad::all();
        return view('modals/modalSolicitud')
        ->with('postgrado',$postgrado)
        ->with('titulos',$titulos)
        ->with('servicioClinico',$servicioClinico)
        ->with('especialidades',$especialidades)
        ->with('capacitaciones',$capacitaciones);
    }

    public function modalEliminarSolicitud($id){
        $solicitud = Solicitud::find($id);
        // dd($id, $solicitud);
        return view('modals/modalEliminarSolicitud')
        ->with('solicitud',$solicitud);
    }

    public function eliminarSolicitud(Request $request){
        $solicitud = Solicitud::find($request->solicitud_id);
        $solicitudEliminada=SolicitudEliminada::create($request->all());
        $solicitud->delete();
        // dd($request->all(), $solicitudEliminada);
        return redirect('/reclutador')->with('status','solicitud_eliminada');
    }


}
