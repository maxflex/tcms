<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Photo;

class UploadController extends Controller
{
    const OK_FACTOR = 50;
    const allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];

    public function galleryOriginal(Request $request)
    {
        // if ($request->file('photo')->getClientSize() > 7654604) { // 7.3 mb с запасом
        //     return response()->json(['error' => 'максимальный объём файла – 7 Мб']);
        // }

        if (!in_array($request->file('photo')->getClientMimeType(), self::allowedMimeTypes)) {
            return response()->json(['error' => 'разрешенные форматы – jpg, png']);
        }

        $gallery = new Gallery($request->all());

        if (!$gallery->is_background) {
            $validWidth  = 4000;
            $validHeight = 2000;
            list($width, $height) = getimagesize($request->file('photo'));
            if ($width != $validWidth || $height != $validHeight) {
                return response()->json(['error' => "не соответствует формату {$validWidth}x{$validHeight}"]);
            }
        }

        $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

        $request->file('photo')->move(Photo::getDir('originals'), $filename);

        if (isset($request->photo_id)) {
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

    public function original(Request $request)
    {
        if ($request->file('photo')->getClientSize() > (1024 * 1024 * 15)) {
            return response()->json(['error' => 'максимальный объём файла – 15 Мб']);
        }
        $filename = uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();
        $request->file('photo')->move(Photo::getDir('originals'), $filename);
        if (isset($request->photo_id)) {
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
        $filename = uniqid() . '.jpg';
        $image = new \claviska\SimpleImage();

        $image
            ->fromFile($request->file('cropped_image'))
            ->resize(2000, null);

        if ($request->watermark) {
            $positionY = 250;
            foreach (range(1, 2) as $i) {
                $positionX = 100;
                foreach (range(1, 4) as $j) {
                    $image->overlay(public_path() . '/img/watermark/watermark.png', 'top left', .4, $positionX, $positionY);
                    $positionX += 560;
                }
                $positionY += 500;
            }
        }

        $image->toFile(Photo::getDir('cropped') . $filename, 'image/jpeg', 20);

        // SMALL

        $image
            ->fromFile($request->file('cropped_image'))
            ->resize(420, null)
            ->toFile(Photo::getDir('small') . $request->id . '.jpg', 'image/jpeg', 80);

        // $request->file('cropped_image')->move(Photo::getDir('cropped'), $filename);
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
