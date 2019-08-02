<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        return Menu::whereNull('menu_id')->get()->all();
    }

    public function store(Request $request)
    {
        return Menu::create($request->all());
    }

    public function update($id, Request $request)
    {
        Menu::find($id)->update($request->all());
    }

    public function destroy($id)
    {
        Menu::find($id)->delete();
    }
}
