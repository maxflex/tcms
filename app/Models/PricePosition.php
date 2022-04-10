<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTags;

class PricePosition extends Model
{
    use HasTags;

    protected $appends = ['tags'];

    protected $fillable = [
        'name',
        'price',
        'unit',
        'price_section_id',
        'position',
        'is_hidden'
    ];

    public function thisLevel()
    {
        return $this->hasMany(self::class, 'price_section_id', 'price_section_id');
    }

    public static function booted()
    {
        static::creating(function ($model) {
            $model->position = $model->thisLevel()->max('position') + 1;
        });
    }
}
