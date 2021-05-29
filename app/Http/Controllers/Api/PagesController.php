<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Http\Requests\PageStoreRequest;
use App\Models\PageItem;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Page::searchByFolder($request->folder)->orderByPosition()->paginate(9999);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageStoreRequest $request)
    {
        $page = Page::create($request->input());
        $page->handleTags($request);
        return $page->fresh();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Page::with('items')->find($id)->makeVisible(['html', 'html_mobile', 'seo_text']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id§
     * @return \Illumi§nate\Http\Response
     */
    public function update(PageStoreRequest $request, $id)
    {
        $page = Page::find($id);
        $page->handleTags($request);
        $page->update($request->input());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = Page::find($id);
        $page->tagEntities()->delete();
        $page->delete();
    }

    /**
     * Check page existance
     */
    public function checkExistance(Request $request, $id = null)
    {
        $query = Page::query();

        if ($id !== null) {
            $query->where('id', '!=', $id);
        }

        return ['exists' => $query->where($request->field, $request->value)->exists()];
    }

    /**
     * Search (used in Link Manager)
     */
    public function search(Request $request)
    {
        return Page::where('keyphrase', 'like', '%' . $request->q . '%')->orWhere('id', $request->q)
            ->select('id', 'keyphrase', \DB::raw("CONCAT(id, ' – ', keyphrase) as title"))->get()->all();
    }

    public function copy(Request $request)
    {
        $page = Page::find($request->id);
        $new = $page->replicate();
        unset($new->id);
        $new->url = uniqid();
        $new->save();
        $new->url = "page-{$new->id}";
        $new->save();
        foreach ($page->items as $item) {
            $new->items()->create($item->toArray());
        }
        return $new->id;
    }
}
