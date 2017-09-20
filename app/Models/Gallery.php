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

    protected $with = ['photos'];

    protected $fillable = [
        'date',
        'days_to_complete',
        'price',
        'name',
        'master_id',
        'tags',
        'count',
        'watermark',
        'before_and_after'
    ];

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
                $positionX = 300;
                foreach(range(1, 3) as $i) {
                    $img->overlay(public_path() . '/img/watermark/watermark.png', 'left', 1, $positionX);
                    $positionX += 600;
                }
            }

            if ($this->before_and_after) {
                $img->overlay(public_path() . '/img/watermark/before.png', 'top left', 1, 471, 786);
                $img->overlay(public_path() . '/img/watermark/after.png', 'top left', 1, 1600, 786);
            }


            if (count($this->photos) > 1) {
                $step = round(2200 / count($this->photos));
                $positionX = $step;
                foreach(range(1, count($this->photos) - 1) as $i) {
                    $img->line($positionX - 2, 0, $positionX - 2, 1100, 'black', 4);
                    $positionX += $step;
                }
            }

            $img->toFile(public_path() . '/img/gallery/' . $this->id . ".png");
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
