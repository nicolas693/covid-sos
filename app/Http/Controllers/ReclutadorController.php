<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesional;
use App\Datos\Posgrado;
use App\Datos\Titulo;
use App\Datos\ServicioClinico;

class ReclutadorController extends Controller
{
    public function index(){
        $solicitud = Profesional::first();
        $capacitaciones=null;
        $postgrado= Posgrado::all();
        $titulos= Titulo::all()->pluck('id','tx_descripcion');
        $servicioClinico= ServicioClinico::all();
        return view('/reclutador')
            // ->with('profesional',$profesional)
            ->with('postgrado',$postgrado)
            ->with('titulos',$titulos)
            ->with('servicioClinico',$servicioClinico);
    }

    public function store(){
        $profesional = Profesional::first();
        return view('/reclutador')->with('profesional',$profesional);
    }
}
