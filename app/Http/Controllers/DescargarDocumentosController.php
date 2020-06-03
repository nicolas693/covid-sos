<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\DocumentosProfesional;

class DescargarDocumentosController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('Roles:3')->only(['certificadoTitulo','cedulaIdentidad','curriculum']);
    } 
    public function certificadoTitulo($id){
      
        $documento = DocumentosProfesional::where('profesional_id',$id)->first()->certificado_titulo;
        $documento =explode('.',$documento);
        $nombre = $documento[0];
        $extension = $documento[1];

        $file = public_path()."/file/".$nombre.'.'.$extension;
        $headers = array('Content-Type: application'.$extension,);
        return Response::download($file, $nombre.'.'.$extension,$headers);
    }

    public function cedulaIdentidad($id){
      
        $documento = DocumentosProfesional::where('profesional_id',$id)->first()->cedula_identidad;
        $documento =explode('.',$documento);
        $nombre = $documento[0];
        $extension = $documento[1];
        
        $file = public_path()."/file/".$nombre.'.'.$extension;
        $headers = array('Content-Type: application/'.$extension,);
        return Response::download($file, $nombre.'.'.$extension,$headers);
    }

    public function curriculum($id){
      
        $documento = DocumentosProfesional::where('profesional_id',$id)->first()->curriculum;
        $documento =explode('.',$documento);
        $nombre = $documento[0];
        $extension = $documento[1];
        
        $file = public_path()."/file/".$nombre.'.'.$extension;
        $headers = array('Content-Type: application/'.$extension,);
        return Response::download($file, $nombre.'.'.$extension,$headers);
    }

   
}
