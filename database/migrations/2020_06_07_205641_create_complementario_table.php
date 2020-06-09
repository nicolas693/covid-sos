<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplementarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('complementarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profesional_id');
            $table->string('eunacom')->nullable();
            $table->string('conacem')->nullable();
            $table->string('supersalud')->nullable();
            $table->string('capacitacion_1')->nullable();
            $table->string('capacitacion_2')->nullable();
            $table->string('capacitacion_3')->nullable();
            $table->string('capacitacion_4')->nullable();
            $table->string('capacitacion_5')->nullable();
            $table->string('capacitacion_6')->nullable();
            $table->string('observaciones')->nullable();

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

            Schema::dropIfExists('complementarios');

    }
}
