<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComponentsToGallery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('price');
        });
        Schema::table('galleries', function (Blueprint $table) {
            $table->integer('price_1')->nullable()->unsigned();
            $table->integer('price_2')->nullable()->unsigned();
            $table->integer('price_3')->nullable()->unsigned();
            $table->integer('price_4')->nullable()->unsigned();
            $table->integer('price_5')->nullable()->unsigned();
            $table->integer('price_6')->nullable()->unsigned();

            $table->string('component_1');
            $table->string('component_2');
            $table->string('component_3');
            $table->string('component_4');
            $table->string('component_5');
            $table->string('component_6');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('galleries', function (Blueprint $table) {
            //
        });
    }
}
