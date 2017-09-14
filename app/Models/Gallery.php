<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTags;
use App\Traits\HasPhotos;

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
