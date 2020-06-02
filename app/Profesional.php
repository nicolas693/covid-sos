<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Datos\EstadoTitulo;

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

    public function getComunasPreferencia()
    {
        $comunasPreferencia =$this->hasMany('App\ComunaPreferencia', 'profesional_id','id')->get();
        $data = [];
        foreach($comunasPreferencia as $cp){
            $comuna =$cp->getComuna();
            $data[$comuna->id] = $comuna->tx_descripcion;

        }
        return $data;
    }

    public function getComunasPreferenciaString()
    {
        $comunasPreferencia =$this->hasMany('App\ComunaPreferencia', 'profesional_id','id')->get();
        $data = [];
        foreach($comunasPreferencia as $cp){
            $comuna =$cp->getComuna();
            $data[$comuna->id] = $comuna->tx_descripcion;

        }
        return join( ',', $data);
    }

    public function getEstadoTitulo()
    {
        $estado =$this->hasOne('App\Datos\EstadoTitulo', 'id','estado_titulo')->first();
        if($estado==null){
            $estado=new EstadoTitulo();
            $estado->tx_descripcion="N/A";
        }
        return $estado;

    }

}
