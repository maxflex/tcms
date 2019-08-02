<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('mobile_menu', 'menu');
        Schema::rename('mobile_menu_sections', 'menu_sections');
        Schema::table('menu_sections', function (Blueprint $table) {
            $table->boolean('is_link')->default(false);
            $table->enum('type', ['mobile', 'desktop'])->default('mobile');
            $table->string('extra')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu', function (Blueprint $table) {
            //
        });
    }
}
