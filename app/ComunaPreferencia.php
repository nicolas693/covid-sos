<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComunaPreferencia extends Model
{
    protected $table = 'comuna_preferencias';

    public function getComuna()
    {
        return $this->hasMany('App\Datos\Comuna', 'id','comuna_id')->first();
    }
}
