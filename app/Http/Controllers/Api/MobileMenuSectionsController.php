<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MobileMenuSection;

class MobileMenuSectionsController extends Controller
{
    public function index()
    {
        return MobileMenuSection::orderBy('position', 'asc')->get();
    }

    public function update($id, Request $request)
    {
        MobileMenuSection::find($id)->update($request->all());
    }

    public function store(Request $request)
    {
        MobileMenuSection::create($request->all());
    }

    public function destroy($id)
    {
        MobileMenuSection::find($id)->delete();
    }
}
