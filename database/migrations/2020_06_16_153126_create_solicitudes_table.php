<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reclutador_id')->nullable();
            $table->unsignedInteger('establecimiento_id')->nullable();
            $table->unsignedInteger('tipo_atencion_id')->nullable();
            $table->unsignedInteger('tipo_profesional_id')->nullable();
            $table->unsignedInteger('especialidad_id')->nullable();
            $table->integer('cantidad')->nullable();
            $table->unsignedInteger('postgrado_id')->nullable();
            $table->unsignedInteger('capacitacion_id')->nullable();
            $table->unsignedInteger('servicio_clinico_id')->nullable();
            $table->integer('anios')->nullable();
            $table->string('jornada')->nullable();
            $table->integer('horas')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_termino')->nullable();
            $table->string('observaciones')->nullable();

            $table->foreign('reclutador_id')->references('id')->on('users');
            $table->foreign('establecimiento_id')->references('establecimiento_id')->on('gen_establecimientos');
            $table->foreign('tipo_profesional_id')->references('id')->on('gen_titulo_profesional');
            $table->foreign('especialidad_id')->references('id')->on('gen_especialidad_medica');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
