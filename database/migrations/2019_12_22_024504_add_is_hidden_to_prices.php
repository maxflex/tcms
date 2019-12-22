<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsHiddenToPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_sections', function (Blueprint $table) {
            $table->boolean('is_hidden');
        });
        Schema::table('price_positions', function (Blueprint $table) {
            $table->boolean('is_hidden');
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
