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
}
