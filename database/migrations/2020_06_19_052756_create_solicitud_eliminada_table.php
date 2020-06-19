<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudEliminadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_eliminada', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reclutador_id')->nullable();
            $table->unsignedBigInteger('solicitud_id')->nullable();
            $table->string('motivo')->nullable();

            $table->foreign('reclutador_id')->references('id')->on('users');
            $table->foreign('solicitud_id')->references('id')->on('solicitudes');

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
        Schema::dropIfExists('solicitud_eliminada');
    }
}
