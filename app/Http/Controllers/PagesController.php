<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Models\Page;
use App\Service\ControllerTemplate;

class PagesController extends Controller
{
    private $template;

    public function __construct()
    {
        $this->template = new ControllerTemplate(Page::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view($this->template->view('index'))->with(ngInit([
            'current_page'  => $request->page,
            'folder'        => $request->folder,
            'template'      => $this->template,
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
            'model'     => new $this->template->class,
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
            'id' => $id,
            'template' => $this->template,
        ]));
    }

    /**
     * Экспорт данных в excel файл
     *
     */
    public function export(Request $request)
    {
        return Page::export($request);
    }

    /**
     * Импорт данных из excel файла
     *
     */
    public function import(Request $request)
    {
        Page::import($request);
    }

    /**
     * Поиск из меню
     */
    public function search(Request $request)
    {
        return $this->index($request, 'Search');
    }
}
