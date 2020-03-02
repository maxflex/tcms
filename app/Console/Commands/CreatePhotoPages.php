<?php

namespace App\Console\Commands;

use DB;
use App\Models\Folder;
use App\Models\Page;
use App\Models\PageItem;
use App\Models\Tag;
use Illuminate\Console\Command;

class CreatePhotoPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-photo-pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create photo pages';

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
        \DB::table('pages')->where('id', '>', 970)->delete();
        $foldersToCopy = [
            10, 157, 644, 645, 649, 650, 646, 647, 648, 651, 652, 653, 716, 655, 717
        ];

        $rootFolder = Folder::create([
            'class' => Page::class,
            'name' => 'Фото',
        ]);

        $bar = $this->output->createProgressBar(count($foldersToCopy));
        foreach ($foldersToCopy as $folderId) {
            $folder = Folder::find($folderId);
            $newFolder = Folder::create([
                'folder_id' => $rootFolder->id,
                'name' => $folder->name,
                'position' => $folder->position,
                'class' => Page::class,
            ]);
            $pages = Page::where('folder_id', $folderId)->get();

            foreach ($pages as $page) {
                $newPage = Page::create([
                    'url' => 'foto-' . $page->url,
                    'h1' => $page->h1,
                    'keyphrase' => $page->keyphrase,
                    'folder_id' => $newFolder->id,
                    'published' => $page->published,
                    'title' => $page->title,
                    'desc' => $page->desc,
                    'position' => $page->position,
                    'html' => <<<EOT
[header|page=main]
    [page.h1]
    [service-list]
    [gallery-block|title=Фотографии работ|ids=|folders=]
    [map-block]
    [gallery-block-2|title=Фотографии ателье|ids=|folders=718]
    <span class="main-page-bottom-text">[page.seo_text]</span>
[footer]
EOT
                ]);
                foreach ($page->tags as $tag) {
                    DB::table('tag_entities')->insert([
                        'entity_type' => Page::class,
                        'entity_id' => $newPage->id,
                        'tag_id' => $tag->id,
                    ]);
                }
                foreach ($page->items as $pageItem) {
                    if (intval($pageItem->href_page_id) > 0) {
                        $hrefPageId = 'foto-' . Page::whereId($pageItem->href_page_id)->value('url');
                    } else {
                        $hrefPageId = null;
                    }
                    PageItem::create([
                        'page_id' => $newPage->id,
                        'href_page_id' => $hrefPageId,
                        'title' => $pageItem->title,
                        'description' => $pageItem->description,
                        'file' => $pageItem->file,
                        'position' => $pageItem->position,
                        'is_one_line' => $pageItem->is_one_line,
                    ]);
                }
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
