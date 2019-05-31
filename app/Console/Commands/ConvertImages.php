<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use WebPConvert\WebPConvert;
use App\Models\Gallery;
use App\Models\Master;
use App\Models\Photo;

class ConvertImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert images to WEBP';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $image = new \claviska\SimpleImage();
        // $ids = Gallery::where('id', '>', 0)->pluck('id');
        // $bar = $this->output->createProgressBar(count($ids));
        // foreach($ids as $id) {
        //     $source = public_path() . '/img/gallery/' . $id . '.jpg';
        //     $thumb = public_path() . '/img/gallery/' . $id . '_thumb.jpg';
        //     $image
        //         ->fromFile($source)
        //         ->resize(288 * 2, 144 * 2)
        //         ->toFile($thumb , 'image/jpeg', 90);

        //     $destination = public_path() . '/img/gallery/' . $id . '.webp';
        //     WebPConvert::convert($source, $destination);

        //     $destination = public_path() . '/img/gallery/' . $id . '_thumb.webp';
        //     WebPConvert::convert($thumb, $destination);

        //     $bar->advance();
        // }
        // $bar->finish();

        // convert master images
        $masters = Master::all();
        $bar = $this->output->createProgressBar(count($masters));
        foreach($masters as $master) {
            foreach($master->photos as $photo) {
                if ($photo->cropped && file_exists($photo->getFullPath())) {
                    $image
                        ->fromFile($photo->getFullPath())
                        ->resize(300, null)
                        ->toFile(Photo::getDir('small') . $photo->id . '.jpg', 'image/jpeg', 80);
                }
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
