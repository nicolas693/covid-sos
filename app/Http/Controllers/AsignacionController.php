<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesional;
use App\Asignacion;

class AsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    public function guardar(Request $request)
    {
        //  dd($request->all(),$request->estado);
        $profesional=Profesional::find($request->profesional_id);

        if($request->modo=="establecimiento"){
            $asignacion=new Asignacion();
            $asignacion->profesional_id=$profesional->id;
            $asignacion->asignador_id="1";//$request->user_id;
            $asignacion->establecimiento=$request->establecimiento;
            $asignacion->observaciones=$request->observaciones;
            $asignacion->save();

            $profesional->estado="contratado";
            $profesional->save();
            return redirect('/callcenter')->with('status', 'asignado');
        }

        //cambio el estado
        $profesional->estado=$request->estadoProfesional;
        $profesional->save();
        return redirect('/callcenter')->with('status', 'cambio_estado');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
