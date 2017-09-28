<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Photo;

class UploadController extends Controller
{
    public function original(Request $request)
    {
        $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->move(Photo::getDir('originals'), $filename);
        $photo = Photo::create([
            'original' => $filename,
            'entity_id' => $request->id,
            'entity_type' => 'App\Models\\' . $request->type,
        ]);
        return $photo;
    }

    public function cropped(Request $request)
    {
        $filename = uniqid() . '.png';
        $img = new \claviska\SimpleImage($request->cropped_image);
        $img->toFile(Photo::getDir('cropped') . $filename, 'image/jpeg', Photo::QUALITY);
        $photo = Photo::find($request->id);
        $photo->update(['cropped' => $filename]);
        return $photo;
    }

    public function pageItem(Request $request)
    {
        $filename = uniqid() . '.' . $request->file('pageitem')->getClientOriginalExtension();
        $request->pageitem->storeAs('pageitems', $filename, 'public');
        return $filename;
    }
}
