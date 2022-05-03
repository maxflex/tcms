<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\{Gallery, Master};
use App\Traits\TagsMassEditable;
use App\Service\ControllerTemplate;

class GalleryController extends Controller
{
    use TagsMassEditable;

    const CLASS_NAME = Gallery::class;
    const ITEM_DIRECTIVE = 'gallery-item';

    public function __construct()
    {
        $this->template = new ControllerTemplate(Gallery::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view($this->template->view('index'))->with(ngInit([
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
        return view($this->template->view('create'))->with(ngInit([
            'model'     => new $this->template->class(['folder_id' => request()->input('folder') ?: null]),
            'masters'   => Master::light()->get(),
            'template'  => $this->template
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
        return view($this->template->view('edit'))->with(ngInit([
            'id'        => $id,
            'masters'   => Master::light()->get(),
            'template'  => $this->template,
        ]));
    }
}
