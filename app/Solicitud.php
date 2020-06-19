<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitud extends Model
{
    use SoftDeletes;

    protected $table = 'solicitudes';
    protected $fillable = ['reclutador_id','establecimiento_id','tipo_profesional_id', 'especialidad_id','cantidad','postgrado_id','capacitacion_id','servicio_clinico_id','anios','jornada','horas','fecha_inicio','fecha_termino','observaciones','dias'];

    public function getTitulo()
    {
        return $this->hasOne('App\Datos\Titulo', 'id', 'tipo_profesional_id')->first();
    }

    public function getEspecialidad()
    {
        $especialidad = $this->hasOne('App\Datos\Especialidad', 'id', 'especialidad_id')->first();
        if ($especialidad == null) {
            return 'SIN ESPECIALIDAD';
        } else {
            return $especialidad;
        }
    }
    public function getPosgrado()
    {
        $posgrado = $this->hasOne('App\Datos\PosGrado', 'id', 'postgrado_id')->first();
        if ($posgrado == null) {
            return 'SIN POSGRADO';
        } else {
            return $posgrado;
        }
    }
    public function getJornada()
    {
        $jornada = $this->hasOne('App\Datos\Disponibilidad', 'id', 'jornada')->first();
        return $jornada;
    }
    public function getServicio()
    {
        $servicio = $this->hasOne('App\Datos\ServicioClinico', 'id', 'servicio_clinico_id')->first();
        return $servicio;
    }
}
