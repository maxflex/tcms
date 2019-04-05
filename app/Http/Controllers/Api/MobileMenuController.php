<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MobileMenu;

class MobileMenuController extends Controller
{
    public function index()
    {
        return MobileMenu::whereNull('menu_id')->get()->all();
    }

    public function store(Request $request)
    {
        return MobileMenu::create($request->all());
    }

    public function update($id, Request $request)
    {
        MobileMenu::find($id)->update($request->all());
    }

    public function destroy($id)
    {
        MobileMenu::find($id)->delete();
    }
}
