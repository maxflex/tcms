<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_menu', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('menu_id')->nullable();
            $table->foreign('menu_id')->references('id')->on('mobile_menu')->onDelete('cascade');

            $table->boolean('is_link')->default(false);

            $table->string('title');
            $table->string('extra');

            $table->unsignedInteger('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_menu');
    }
}
