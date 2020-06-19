<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudEliminada extends Model
{
    protected $table = 'solicitud_eliminada';
    protected $fillable = ['reclutador_id','solicitud_id','motivo'];

}
