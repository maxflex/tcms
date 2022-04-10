<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\{PriceSection, PricePosition, Tag};

class PricesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('prices.index')->with(ngInit([
            'id' => $request->id,
            'tree' => $request->id ? PriceSection::find($request->id)->tree : null,
            'current_page' => $request->page
        ]));
    }

    public function create()
    {
        $price_sections = PriceSection::select('id', 'name')->get();
        return view('prices.create')->with(ngInit([
            'model' => new PriceSection(['price_section_id' => request()->input('id') ?: null]),
            'price_sections' => $price_sections
        ]));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $price_sections = PriceSection::select('id', 'name')->get();
        return view('prices.edit')->with(ngInit(compact('id', 'price_sections')));
    }

    public function tag(Request $request, $id)
    {
        $tag = Tag::find($id);

        $items = self::getFolderItems(null);

        return view('tags.mass-edit')->with(ngInit([
            'items'        => $items,
            'tag'          => $tag,
            'class' => PricePosition::class,
        ]))->with([
            'tag' => $tag,
            'directive' => 'price-item-tag'
        ]);
    }

    private static function getFolderItems($folder_id)
    {
        $folders = PriceSection::where('price_section_id', $folder_id)->orderBy('position')->get()->all();

        $items = [];
        foreach ($folders as $folder) {
            $folder->items = self::getFolderItems($folder->id);
            $items[] = $folder;
        }

        $folder_items = PricePosition::where('price_section_id', $folder_id)->orderBy('position')->get()->all();

        return array_merge($items, $folder_items);
    }
}
