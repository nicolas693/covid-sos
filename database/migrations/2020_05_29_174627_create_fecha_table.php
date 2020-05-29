<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFechaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profesional_id')->nullable();
            $table->string('dia')->nullable();
            $table->string('hora_inicio')->nullable();
            $table->string('hora_termino')->nullable();

            $table->foreign('profesional_id')
                ->references('id')
                ->on('profesionales');

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
        Schema::dropIfExists('fechas');
    }
}
