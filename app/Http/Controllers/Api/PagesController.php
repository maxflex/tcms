<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Page;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Page::orderBy('position', 'asc');

        if ($request->folder) {
            $query->where('folder_id', $request->folder);
        } else {
            $query->whereNull('folder_id');
        }

        return $query->paginate(30);
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
    public function store(Request $request)
    {
        return Page::create($request->input())->fresh();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Page::with('items')->find($id)->append('tags')->makeVisible(['html', 'html_mobile', 'seo_text']);
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
    public function update(Request $request, $id)
    {
        Page::find($id)->update($request->input());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Page::destroy($id);
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
        return $new->id;
    }
}
