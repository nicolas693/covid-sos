<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaCallCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cola_call_centers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('lugar_cola');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('indice',3)->default('0');
            $table->string('activo',3)->default('1');
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
        Schema::dropIfExists('cola_call_centers');
    }
}
