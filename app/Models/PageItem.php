<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'page_id',
        'href_page_id',
        'title',
        'description',
        'file',
        'position'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->position = self::where('page_id', $model->page_id)->max('position') + 1;
        });
    }
}
