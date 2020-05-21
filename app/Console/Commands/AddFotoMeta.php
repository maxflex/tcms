<?php

namespace App\Console\Commands;

use App\Models\Folder;
use App\Models\Page;
use Illuminate\Console\Command;

class AddFotoMeta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-foto-meta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $folders = Folder::where('folder_id', 735)->get();

        foreach ($folders as $folder) {
            $pages = Page::where('folder_id', $folder->id)->get();
            foreach ($pages as $page) {
                $h1 = $page->h1;
                $page->h1 = $h1 . ' – ' . (mt_rand(0, 1) ? 'фото итогов нашей работы' : 'фото работ наших мастеров');
                $page->title = $h1 . ' – ' . (mt_rand(0, 1) ? 'фото итогов работы в Ателье Талисман' : 'фото до и после в Ателье Талисман');

                $desc = collect([
                    'У нас ✔ выгодные цены ✔ высокое качество ✔ удобные часы работы, наш телефон в Москве ☎ (495) 215-22-31',
                    'Прямое общение с мастерами, нет никаких записей и очередей, возможность безналичной оплаты',
                    'У нас нет никаких записей и очередей, а о готовности заказа мы сообщим Вам по смс'
                ])->random();
                $page->desc = "{$h1} в Ателье Талисман. Фото работ до и после. {$desc}";
                $page->save();
            }
        }
    }
}
