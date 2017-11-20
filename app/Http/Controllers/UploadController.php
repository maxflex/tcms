<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Photo;

class UploadController extends Controller
{
    const OK_FACTOR = 50;
    const allowedMimeTypes = ['image/jpeg','image/jpg','image/png'];

    public function original(Request $request)
    {
        if ($request->file('photo')->getClientSize() > 5000000) {
            return response()->json(['error' => 'максимальный объём файла – 5 Мб']);
        }

        if (! in_array($request->file('photo')->getClientMimeType(), self::allowedMimeTypes)) {
            return response()->json(['error' => 'разрешенные форматы – jpg, png']);
        }

        /** validations **/
        $min_height = 1100 + self::OK_FACTOR;
        $min_width  = 2200 / $request->count + self::OK_FACTOR;

        list($width, $height) = getimagesize($request->file('photo'));

        if ($width < $min_width || $height < $min_height) {
            return response()->json(['error' => 'не соответствует минимальной высоте или ширине']);
        }


        $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

        $request->file('photo')->move(Photo::getDir('originals'), $filename);

        if ( isset($request->photo_id)) {
            // todo: удаление старого фото
            $photo = Photo::find($request->photo_id);
            $photo->update(['original' => $filename]);
        } else {
            $photo = Photo::create([
                'original' => $filename,
                'entity_id' => $request->id,
                'entity_type' => 'App\Models\\' . $request->type,
            ]);
        }
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
