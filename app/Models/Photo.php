<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    const UPLOAD_DIR = '/photos/';

    protected $fillable = [
        'original',
        'cropped',
        'entity_id',
        'entity_type'
    ];

    protected $appends = [
        'original_url',
        'cropped_url',
        'file_size',
        'image_size',
    ];

    public $timestamps = false;

    public static function getDir($folder = false)
    {
        return public_path() . self::UPLOAD_DIR . ($folder ? "{$folder}/" : '');
    }

    public function getOriginalUrlAttribute()
    {
        if (@$this->attributes['original']) {
            return  self::UPLOAD_DIR . 'originals/' . $this->attributes['original'];
        }
    }

    public function getCroppedUrlAttribute()
    {
        if (@$this->attributes['cropped']) {
            return  self::UPLOAD_DIR . 'cropped/' . $this->attributes['cropped'];
        }
    }

    public function getFileSizeAttribute()
    {
        if (@$this->attributes['cropped']) {
            return getSize(self::getDir('cropped') . $this->attributes['cropped']);
        }
    }

    public function getImageSizeAttribute()
    {
        if (@$this->attributes['cropped']) {
            list($width, $height) = getimagesize(self::getDir('cropped') . $this->attributes['cropped']);
            return "{$width}x{$height}";
        }
    }
}
