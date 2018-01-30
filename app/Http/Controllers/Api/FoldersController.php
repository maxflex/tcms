<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Folder;
use DateTime;

class FoldersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (filter_var($request->save_visited_folder_id, FILTER_VALIDATE_BOOLEAN)) {
            setcookie(Folder::getCookieKey($request->class), $request->current_folder_id, (new DateTime)->modify('+1 year')->getTimestamp(), '/');
        }
        return Folder::where('class', $request->class)
            ->searchByFolder($request->current_folder_id)
            ->orderByPosition()
            ->get();
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
        return Folder::create($request->input())->fresh();
    }

    /**
     * Find parent folder
     *
     */
    public function show($id)
    {
        $folder = Folder::find($id);
        if ($folder->folder_id) {
            return Folder::find($folder->folder_id);
        }
        return null;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Folder::find($id)->update($request->input());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Folder::destroy($id);
    }
}
