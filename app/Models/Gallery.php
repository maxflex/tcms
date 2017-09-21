<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTags;
use App\Traits\HasPhotos;
use PHPImageWorkshop\ImageWorkshop;
use claviska\SimpleImage;

class Gallery extends Model
{
    use HasTags, HasPhotos;

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
        'before_and_after'
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
            $emptyLayer = ImageWorkshop::initVirginLayer(2200, 1100);
            $positionX = 0;
            foreach($this->photos as $photo) {
                $layer = ImageWorkshop::initFromPath($photo->getFullPath());
                $emptyLayer->addLayerOnTop($layer, $positionX);
                $positionX += 2200 / count($this->photos);
            }
            $emptyLayer->save(public_path() . '/img/gallery/', $this->id . ".png", true, null, 95);

            // watermark, до и после
            $img = new SimpleImage(public_path() . '/img/gallery/' . $this->id . ".png");

            if ($this->watermark) {
                // $img->overlay(public_path() . '/img/watermark/watermark.png', 'top left', 1);
                $positionX = 0;
                foreach(range(1, 3) as $i) {
                    $img->overlay(public_path() . '/img/watermark/watermark.png', 'left', .8, $positionX);
                    $positionX += 800;
                }
            }

            if ($this->before_and_after && $this->count == 2) {
                // x = 450 | 550 - (200/2)
                $img->overlay(public_path() . '/img/watermark/before.png', 'top left', 1, 450, 790);
                // x = 1550 | 1650 - (200/2)
                $img->overlay(public_path() . '/img/watermark/after.png', 'top left', 1, 1550, 790);
            }


            if (count($this->photos) > 1) {
                $step = round(2200 / count($this->photos));
                $positionX = $step;
                foreach(range(1, count($this->photos) - 1) as $i) {
                    $img->line($positionX - 2, 0, $positionX - 2, 1100, 'black', 4);
                    $positionX += $step;
                }
            }

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
        static::saved(function($model) {
            // удалить фото, если их больше, чем в count
            if (count($model->photos) > $model->count) {
                foreach($model->photos as $index => $photo) {
                    if (($index + 1) > $model->count) {
                        $photo->delete();
                    }
                }
            }
            $model->createImage();
        });
    }
}
