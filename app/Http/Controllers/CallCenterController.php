<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesional;

class CallCenterController extends Controller
{
    public function index(){
        $profesionales = Profesional::all();
        return view('/callcenter')->with('profesionales',$profesionales);
    }
    public function verInfo($id){
        $profesional = Profesional::find($id);
        return view('modals/modalInfo')->with('profesional',$profesional);
    }
}
