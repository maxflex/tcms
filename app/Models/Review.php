<?php

namespace App\Models;

use \Shared\Model;
use App\Traits\HasTags;

class Review extends Model
{
    use HasTags;

    protected $fillable = [
        'date',
        'signature',
        'body',
        'score',
        'published',
        'master_id',
        'tags'
    ];

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = fromDotDate($value);
    }

    public function getDateAttribute($value)
    {
        return dateFormat($value, true);
    }
}
