<?php

namespace App\Datos;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table="gen_pais";
    protected $fillable=[
        'cd_pais',
        'tx_descripcion',
        'sigla_pais'
    ];
}
