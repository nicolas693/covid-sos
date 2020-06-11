<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHepatitisToComplementario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complementarios', function (Blueprint $table) {
            $table->string('hepatitisA')->nullable();
            $table->string('hepatitisB')->nullable();
            $table->string('hepatitisC')->nullable();
            $table->string('influenza')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complementarios', function (Blueprint $table) {
            $table->dropColumn(['hepatitisA']);
            $table->dropColumn(['hepatitisB']);
            $table->dropColumn(['hepatitisC']);
            $table->dropColumn(['influenza']);
        });
    }
}
