<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesional;

class ReclutadorController extends Controller
{
    public function index(){
        $profesionales = Profesional::all();
        return view('/reclutador')->with('profesionales',$profesionales);
    }
}
