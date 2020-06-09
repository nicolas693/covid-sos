<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsComplementarios extends Migration
{

    public function up()
    {
        Schema::table('complementarios', function(Blueprint $table) {
            $table->renameColumn('capacitacion_1', 'iaas');
            $table->string('iaasCurso')->nullable();
            $table->renameColumn('capacitacion_2', 'rcp');
            $table->string('rcpCurso')->nullable();
            $table->renameColumn('capacitacion_3', 'pacienteCritico');
            $table->string('pacienteCriticoCurso')->nullable();
            $table->renameColumn('capacitacion_4', 'ventilacionMecanica');
            $table->string('ventilacionMecanicaCurso')->nullable();
            $table->renameColumn('capacitacion_5', 'adminEstado');
            $table->string('adminEstadoCurso')->nullable();
            $table->renameColumn('capacitacion_6', 'urgenciaDesastres');
            $table->string('urgenciaDesastresCurso')->nullable();
            $table->string('adultoMayor')->nullable();
            $table->string('adultoMayorCurso')->nullable();
            $table->string('infeccionesRespiratorias')->nullable();
            $table->string('infeccionesRespiratoriasCurso')->nullable();
            $table->string('ira')->nullable();
            $table->string('iraCurso')->nullable();
            $table->string('era')->nullable();
            $table->string('eraCurso')->nullable();
            $table->string('covid19')->nullable();
            $table->string('covid19Curso')->nullable();
            $table->string('otro')->nullable();
            $table->string('otroCurso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn(['iaasCurso']);
        $table->dropColumn(['rcpCurso']);
        $table->dropColumn(['pacienteCriticoCurso']);
        $table->dropColumn(['ventilacionMecanicaCurso']);
        $table->dropColumn(['adminEstadoCurso']);
        $table->dropColumn(['urgenciaDesastresCurso']);
        $table->dropColumn(['adultoMayorCurso']);
        $table->dropColumn(['infeccionesRespiratoriasCurso']);
        $table->dropColumn(['iraCurso']);
        $table->dropColumn(['eraCurso']);
    }
}
