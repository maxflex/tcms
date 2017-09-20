<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionToPriceSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_sections', function (Blueprint $table) {
            $table->integer('position')->unsigned();
        });
        Schema::table('price_positions', function (Blueprint $table) {
            $table->integer('position')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_sections', function (Blueprint $table) {
            //
        });
    }
}
