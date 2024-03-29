<?php

namespace App\Models;

use App\Traits\{HasTags, Folderable};

class Review extends Model
{
    use HasTags, Folderable;

    protected $fillable = [
        'date',
        'signature',
        'body',
        'score',
        'published',
        'master_id',
        'folder_id',
        'position',
        // 'tags'
    ];

    public $appends = ['tags'];

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = fromDotDate($value);
    }

    public function getDateAttribute($value)
    {
        return dateFormat($value, true);
    }
}
