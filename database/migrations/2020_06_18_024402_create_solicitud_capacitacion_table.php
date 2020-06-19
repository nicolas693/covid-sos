<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudCapacitacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_capacitacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('solicitud_id')->nullable();
            $table->unsignedInteger('capacitacion_id')->nullable();

            $table->foreign('solicitud_id')->references('id')->on('solicitudes');
            $table->foreign('capacitacion_id')->references('id')->on('gen_capacitaciones');

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
        Schema::dropIfExists('solicitud_capacitacion');
    }
}
