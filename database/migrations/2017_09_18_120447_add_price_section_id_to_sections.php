<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceSectionIdToSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_sections', function (Blueprint $table) {
            $table->integer('price_section_id')->unsigned()->nullable();
            $table->foreign('price_section_id')->references('id')->on('price_sections')->onDelete('set null');
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
        });
    }
}
