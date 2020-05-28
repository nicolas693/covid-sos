<?php

namespace App\Datos;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table="paises";
    protected $fillable=[
        'cd_pais',
        'tx_descripcion',
        'sigla_pais'
    ];
}
