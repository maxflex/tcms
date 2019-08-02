<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MenuSection;

class MenuSectionsController extends Controller
{
    public function index(Request $request)
    {
        return MenuSection::where('type', $request->type)->orderBy('position', 'asc')->get();
    }

    public function update($id, Request $request)
    {
        MenuSection::find($id)->update($request->all());
    }

    public function store(Request $request)
    {
        MenuSection::create($request->all());
    }

    public function destroy($id)
    {
        MenuSection::find($id)->delete();
    }
}
