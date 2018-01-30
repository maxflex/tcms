<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Gallery;

class DropGalleryIdForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['folder_id']);
        });

        $gallery_folders = \DB::table('gallery_folders')->get()->all();

        foreach($gallery_folders as $folder) {
            $new_folder = \App\Models\Folder::create([
                'name' => $folder->name,
                'class' => Gallery::class
            ]);
            Gallery::where('folder_id', $folder->id)->update(['folder_id' => $new_folder->id]);
        }

        Schema::table('galleries', function (Blueprint $table) {
            $table->integer('folder_id')->unsigned()->nullable()->change();
            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('set null');
        });

        Schema::drop('gallery_folders');
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
