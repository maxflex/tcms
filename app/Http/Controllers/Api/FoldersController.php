<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Folder;
use DateTime;

class FoldersController extends Controller
{
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
     * Get folder tree
     */
    public function tree(Request $request)
    {
        return Folder::getLevel($request->class);
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
    public function breadcrumbs($id)
    {
        $breadcrumbs = [];
        $current_folder = Folder::find($id);
        while (true) {
            $breadcrumbs[] = [
                'id'    => $current_folder->id,
                'name'  => $current_folder->name,
            ];
            if ($current_folder->folder_id) {
                $current_folder = Folder::find($current_folder->folder_id);
            } else {
                break;
            }
        }
        return array_reverse($breadcrumbs);
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
