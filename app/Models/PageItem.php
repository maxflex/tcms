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
        'position',
        'is_one_line'
    ];

    public static function booted()
    {
        static::creating(function ($model) {
            $model->position = self::where('page_id', $model->page_id)->max('position') + 1;
        });
    }
}
