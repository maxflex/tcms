<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSectionIdToMobileMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_menu', function (Blueprint $table) {
            $table->unsignedInteger('section_id')->nullable();
            $table->foreign('section_id')->references('id')->on('mobile_menu_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_menu', function (Blueprint $table) {
            //
        });
    }
}
