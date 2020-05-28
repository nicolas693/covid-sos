<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Datos\Pais;

class LiveSearchController extends Controller
{
    function getNacionalidades(Request $request)
    {
        $data = Pais::where('tx_descripcion', 'LIKE', '%' . $request->name . '%')
            ->orWhere('cd_pais', 'LIKE', '%' . $request->name . '%')
            ->get()->take(10)->map(function ($item) {
                return ["id" => $item->cd_pais, "text" => $item->tx_descripcion];
            });
        return response()->json($data);
    }
}
