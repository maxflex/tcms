<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTags;

class PricePosition extends Model
{
    use HasTags;

    protected $fillable = [
        'name',
        'price',
        'unit',
        'price_section_id',
        'position',
        'tags',
    ];
}
