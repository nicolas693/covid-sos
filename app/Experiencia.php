<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experiencia extends Model
{
    use SoftDeletes; //Implementamos
    protected $table = 'experiencias';
}
