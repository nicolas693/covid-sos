<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use App\Datos\Establecimiento;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    public function getNombreEstablecimiento()
    {
        return Establecimiento::where("establecimiento_id",$this->establecimiento)->first()->tx_descripcion;
    }
}
