<?php

namespace App\Datos;

use Illuminate\Database\Eloquent\Model;

class Disponibilidad extends Model
{
    protected $table = 'disponibilidades';

    public function getModalidades()
    {
        $comunasResidencia =$this->hasMany('App\Datos\ModalidadDisponibilidad', 'disponibilidad_id','id')->select('id','tx_descripcion')->get()->toArray();
        return $comunasResidencia;
    }
}
