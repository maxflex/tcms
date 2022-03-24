<?php

namespace App\Models;

use App\Traits\Folderable;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTags;
use Storage;

class Video extends Model
{
    use HasTags, Folderable;

    protected $fillable = ['code', 'title', 'master_id', 'position', 'duration', 'folder_id'];
    protected $appends = ['tags'];

    public static function booted()
    {
        static::saved(function ($model) {
            $image = new \claviska\SimpleImage();
            $image
                ->fromFile('https://img.youtube.com/vi/' . $model->code . '/mqdefault.jpg')
                ->toFile(public_path() . '/img/video/' . $model->id . '.jpg', 'image/jpeg', 90);
            // Storage::disk('spaces')->put('/img/video/' . $model->id . '.jpg', file_get_contents('https://img.youtube.com/vi/' . $model->code . '/mqdefault.jpg'));
        });
    }
}
