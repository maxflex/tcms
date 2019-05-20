<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTags;
use Storage;

class Video extends Model
{
    use HasTags;

    protected $fillable = ['code', 'title', 'tags', 'master_id', 'position', 'duration'];
    protected $appends = ['tags'];

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Storage::disk('spaces')->put('/img/video/' . $model->id . '.jpg', file_get_contents('https://img.youtube.com/vi/' . $model->code . '/mqdefault.jpg'));
        });
    }
}
