<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rut','name', 'email','user_type', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getProfesional()
    {
        $profesional = $this->hasOne('App\Profesional', 'user_id','id')->first();
        return $profesional;
    }

    public function obtenerTipoUsuario()
    {
        $profesional = $this->hasOne('App\UserType', 'id','user_type')->first()->tx_descripcion;
        return $profesional;
    }
}
