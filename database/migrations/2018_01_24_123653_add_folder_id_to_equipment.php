<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFolderIdToEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->integer('folder_id')->unsigned()->nullable();
            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('set null');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->integer('folder_id')->unsigned()->nullable();
            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipment', function (Blueprint $table) {
            //
        });
    }
}
