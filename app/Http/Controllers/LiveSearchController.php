<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Datos\Pais;
use App\Datos\Titulo;
use App\Datos\Especialidad;

class LiveSearchController extends Controller
{
    function getNacionalidades(Request $request)
    {
        $someModel = new Pais();

        $someModel->setConnection('masterdb'); 

        $data = $someModel->where('tx_descripcion', 'LIKE', '%' . $request->name . '%')
            ->orWhere('cd_pais', 'LIKE', '%' . $request->name . '%')
            ->get()->take(10)->map(function ($item) {
                return ["id" => $item->id, "text" => $item->tx_descripcion];
            });
        return response()->json($data);
    }

    function getProfesiones(Request $request)
    {
        $someModel = new Titulo();

        $someModel->setConnection('masterdb'); 

        $data = $someModel->where('tx_descripcion', 'LIKE', '%' . $request->name . '%')
            ->orWhere('cd_tipo_profesional', 'LIKE', '%' . $request->name . '%')
            ->get()->take(10)->map(function ($item) {
                return ["id" => $item->id, "text" => $item->tx_descripcion];
            });
        return response()->json($data);
    }

    function getEspecialidades(Request $request)
    {
        $someModel = new Especialidad();

        $someModel->setConnection('masterdb'); 

        $data = $someModel->where('tx_descripcion', 'LIKE', '%' . $request->name . '%')
            ->orWhere('cd_especialidad_medica', 'LIKE', '%' . $request->name . '%')
            ->get()->take(10)->map(function ($item) {
                return ["id" => $item->id, "text" => $item->tx_descripcion];
            });
        return response()->json($data);
    }
}
