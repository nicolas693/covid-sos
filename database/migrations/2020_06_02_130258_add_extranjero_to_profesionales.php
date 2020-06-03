<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtranjeroToProfesionales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profesionales', function (Blueprint $table) {
            $table->tinyInteger('tipo_identificacion')->after("id");
            $table->tinyInteger('extranjero')->after("tipo_identificacion");
            $table->string('pasaporte',20)->after('rut')->nullable();
            $table->string('rut_provisorio',11)->after('pasaporte')->nullable();
            $table->unsignedBigInteger('user_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profesionales', function (Blueprint $table) {
            $table->dropColumn('tipo_identificacion');
            $table->dropColumn('extranjero');
            $table->dropColumn('pasaporte');
            $table->dropColumn('rut_provisorio');
            $table->dropColumn('user_id');
        });
    }
}
