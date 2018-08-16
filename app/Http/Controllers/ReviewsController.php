<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\{Review, Master};
use App\Traits\TagsMassEditable;
use App\Service\ControllerTemplate;

class ReviewsController extends Controller
{
    use TagsMassEditable;

    const CLASS_NAME = Review::class;
    const ITEM_DIRECTIVE = 'review-item';

    public function __construct()
    {
        $this->template = new ControllerTemplate(Review::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('reviews.index')->with(ngInit([
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
        return view('reviews.create')->with(ngInit([
            'model' => new Review,
            'masters' => $masters,
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
        $masters = Master::light()->get();
        $template = $this->template;
        return view('reviews.edit')->with(ngInit(compact('id', 'masters', 'template')));
    }
}
