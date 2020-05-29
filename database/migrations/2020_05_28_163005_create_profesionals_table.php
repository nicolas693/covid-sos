<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('profesionales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rut',11);
            $table->string('nombre',100);
            $table->string('apellido_paterno',30);
            $table->string('apellido_materno',30);
            $table->string('telefono',30);
            $table->string('email',50);
            $table->string('direccion',80);
            $table->string('pais',30);
            $table->string('tipo_profesional',30);
            $table->string('especialidad',30)->nullable();
            $table->timestamps();

            // CÓDIGO PARA LLAVE FORANEA DE TABLA DISPONIBILIDAD
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profesionales');
    }
}
