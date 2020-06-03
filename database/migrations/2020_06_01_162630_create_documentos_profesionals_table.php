<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosProfesionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_profesionales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('profesional_id');
            $table->string('certificado_titulo',100)->nullable();
            $table->string('curriculum',100)->nullable();
            $table->string('cedula_identidad',100)->nullable();
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
        Schema::dropIfExists('documentos_profesionales');
    }
}
