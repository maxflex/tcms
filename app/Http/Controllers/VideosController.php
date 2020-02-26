<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\{Video, Master};
use App\Service\ControllerTemplate;
use App\Traits\TagsMassEditable;

class VideosController extends Controller
{
    use TagsMassEditable;

    const CLASS_NAME = Video::class;
    const ITEM_DIRECTIVE = 'review-item';

    public function __construct()
    {
        $this->template = new ControllerTemplate(Video::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('videos.index')->with(ngInit([
            'current_page' => $request->page,
            'folder'       => $request->folder,
            'template'     => $this->template,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $masters = Master::light()->get();
        return view('videos.create')->with(ngInit([
            'model' => new Video,
            'masters' => $masters,
            'template' => $this->template,
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
        $masters = Master::light()->get();
        $template = $this->template;
        return view('videos.edit')->with(ngInit(compact('id', 'masters', 'template')));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
