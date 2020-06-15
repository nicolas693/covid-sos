<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\DocumentosProfesional;
use File;

class DescargarDocumentosController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('Roles:3')->only(['certificadoTitulo','cedulaIdentidad','curriculum']);
    } 
    public function certificadoTitulo($id){
      
        $documento = DocumentosProfesional::where('profesional_id', $id)->orderBy('created_at','desc')->first()->certificado_titulo;
        $documento =explode('.',$documento);
        $nombre = $documento[0];
        $extension = $documento[1];

        $file = public_path()."/file/".$nombre.'.'.$extension;
        $headers = array('Content-Type: application'.$extension,);
        if(File::exists($file)){
            return Response::download($file, $nombre.'.'.$extension,$headers);
        }else{
            return redirect('/callcenter')->with('message', 'error al buscar archivo');
        }
    }

    public function cedulaIdentidad($id){
      
        $documento = DocumentosProfesional::where('profesional_id', $id)->orderBy('created_at','desc')->first()->cedula_identidad;
        $documento =explode('.',$documento);
        $nombre = $documento[0];
        $extension = $documento[1];
        
        $file = public_path()."/file/".$nombre.'.'.$extension;
        $headers = array('Content-Type: application/'.$extension,);
        if(File::exists($file)){
            return Response::download($file, $nombre.'.'.$extension,$headers);
        }else{
            return redirect('/callcenter')->with('message', 'error al buscar archivo');
        }
    }

    public function curriculum($id){
      
        $documento = DocumentosProfesional::where('profesional_id', $id)->orderBy('created_at','desc')->first()->curriculum;
        $documento =explode('.',$documento);
        $nombre = $documento[0];
        $extension = $documento[1];
        
        $file = public_path()."/file/".$nombre.'.'.$extension;
        $headers = array('Content-Type: application/'.$extension,);
        if(File::exists($file)){
            return Response::download($file, $nombre.'.'.$extension,$headers);
        }else{
            return redirect('/callcenter')->with('message', 'error al buscar archivo');
        }
    }

    public function capacitacion($id){
      
        $documento = DocumentosProfesional::where('profesional_id', $id)->orderBy('created_at','desc')->first()->capacitacion;
        $documento =explode('.',$documento);
        $nombre = $documento[0];
        $extension = $documento[1];
       
        $file = public_path()."/file/".$nombre.'.'.$extension;
        $headers = array('Content-Type: application/'.$extension,);
        if(File::exists($file)){
            return Response::download($file, $nombre.'.'.$extension,$headers);
        }else{
            return redirect('/callcenter')->with('message', 'error al buscar archivo');
        }
        
    }

   
}
