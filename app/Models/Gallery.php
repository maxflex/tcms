<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTags;
use App\Traits\HasPhotos;
use App\Traits\Folderable;
use PHPImageWorkshop\ImageWorkshop;
use claviska\SimpleImage;

class Gallery extends Model
{
    use HasTags, HasPhotos, Folderable;

    protected $fillable = [
        'date',
        'days_to_complete',
        'price_1', 'price_2', 'price_3', 'price_4', 'price_5', 'price_6',
        'component_1', 'component_2', 'component_3', 'component_4', 'component_5', 'component_6',
        'name',
        'master_id',
        'tags',
        'count',
        'watermark',
        'before_and_after',
        'position',
        'folder_id'
    ];

    protected $appends = ['file_size', 'has_photo', 'image_size'];

    protected $casts = [
        'watermark' => 'boolean',
        'before_and_after' => 'boolean',
    ];

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = fromDotDate($value);
    }

    public function getDateAttribute($value)
    {
        return dateFormat($value, true);
    }

    public function createImage()
    {
        if (count($this->photos)) {
            //$emptyLayer = ImageWorkshop::initVirginLayer(2200, 1100);
            // $positionX = 0;
            // foreach($this->photos as $photo) {
            //     $layer = ImageWorkshop::initFromPath($photo->getFullPath());
            //     $emptyLayer->addLayerOnTop($layer, $positionX);
            //     $positionX += 2200 / count($this->photos);
            // }
            // $emptyLayer->save(public_path() . '/img/gallery/', $this->id . ".png", true, null, 95);

            // watermark, до и после
            $img = new SimpleImage;
            $img->fromFile(public_path() . $this->photos[0]->original_url)->resize(2200, 1100);

            if ($this->watermark) {
                // $img->overlay(public_path() . '/img/watermark/watermark.png', 'top left', 1);

                $positionY = 250;
                foreach(range(1, 2) as $i) {
                    $positionX = 100;
                    foreach(range(1, 4) as $j) {
                        $img->overlay(public_path() . '/img/watermark/watermark.png', 'top left', .4, $positionX, $positionY);
                        $positionX += 560;
                    }
                    $positionY += 500;
                }
            }

            if ($this->before_and_after) {
                // x = 450 | 550 - (240/2)
                $img->overlay(public_path() . '/img/watermark/before.png', 'top left', 1, 760, 790);
                // x = 1550 | 1650 - (240/2)
                $img->overlay(public_path() . '/img/watermark/after.png', 'top left', 1, 1165, 790);
            }


            // if (count($this->photos) > 1) {
            //     $step = round(2200 / count($this->photos));
            //     $positionX = $step;
            //     foreach(range(1, count($this->photos) - 1) as $i) {
            //         $img->line($positionX - 2, 0, $positionX - 2, 1100, 'black', 4);
            //         $positionX += $step;
            //     }
            // }

            $img->toFile(public_path() . '/img/gallery/' . $this->id . ".jpg", 'image/jpeg' , Photo::QUALITY);
        }
    }

    public function getHasPhotoAttribute()
    {
        return file_exists(public_path() . '/img/gallery/' . $this->id . ".jpg");
    }

    public function getFileSizeAttribute()
    {
        if ($this->has_photo) {
            return getSize(public_path() . '/img/gallery/' . $this->id . ".jpg");
        }
    }

    public function getImageSizeAttribute()
    {
        if ($this->has_photo) {
            list($width, $height) = getimagesize(public_path() . '/img/gallery/' . $this->id . ".jpg");
            return "{$width}×{$height}";
        }
    }

    public static function boot()
    {
        static::saving(function($model) {
            $model->createImage();
        });
    }
}
