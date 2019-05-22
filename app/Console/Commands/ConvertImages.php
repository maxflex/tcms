<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use WebPConvert\WebPConvert;
use App\Models\Gallery;

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
        $ids = Gallery::where('id', '>', 0)->pluck('id');
        $bar = $this->output->createProgressBar(count($ids));
        foreach($ids as $id) {
            $source = public_path() . '/img/gallery/' . $id . '.jpg';
            $destination = public_path() . '/img/gallery/' . $id . '.webp';
            WebPConvert::convert($source, $destination);
            $bar->advance();
        }
        $bar->finish();
    }
}
