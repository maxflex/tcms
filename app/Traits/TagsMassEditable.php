<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\{Tag, Folder};

trait TagsMassEditable
{
    public function tag(Request $request, $id)
    {
        $tag = Tag::find($id);

        $items = self::getFolderItems(null);

        return view('tags.mass-edit')->with(ngInit([
            'items'        => $items,
            'tag'          => $tag,
            'class' => self::CLASS_NAME,
        ]))->with([
            'tag' => $tag,
            'directive' => self::ITEM_DIRECTIVE
        ]);
    }

    private static function getFolderItems($folder_id)
    {
        $class_name = self::CLASS_NAME;

        $folders = Folder::whereClass($class_name)->searchByFolder($folder_id)->orderByPosition()->get()->all();

        $items = [];
        foreach($folders as $folder) {
            $folder->items = self::getFolderItems($folder->id);
            $items[] = $folder;
        }

        $folder_items = $class_name::searchByFolder($folder_id)->orderByPosition()->get()->all();

        return array_merge($items, $folder_items);
    }
}
