<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesional extends Model
{
    protected $table = 'profesionales';
    protected $fillable = [
        'rut',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'email',
        'direccion',
        'pais',
        'tipo_profesional',
        'especialidad'
    ];

    public function getTitulo()
    {
        return $this->hasOne('App\Datos\Titulo', 'id','tipo_profesional')->first();
    }

    public function getEspecialidad()
    {
        $especialidad =$this->hasOne('App\Datos\Especialidad', 'id','especialidad')->first();
        if($especialidad == null){
            return 'vacio';
        }else{
            return $especialidad;
        }
    }

    public function getPais()
    {
        return $this->hasOne('App\Datos\Pais', 'id','pais')->first();
    }

}
