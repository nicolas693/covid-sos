<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperienciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiencias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profesional_id')->nullable();
            $table->string('tiempoTipo')->nullable();
            $table->string('tiempoPeriodo')->nullable();
            $table->string('servicioClinico')->nullable();
            $table->string('lugarTrabajo')->nullable();

            $table->foreign('profesional_id')->references('id')->on('profesionales');
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
        Schema::dropIfExists('experiencias');
    }
}
