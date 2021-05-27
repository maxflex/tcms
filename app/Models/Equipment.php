<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\{HasPhotos, HasTags, Folderable};

class Equipment extends Model
{
    use HasPhotos, HasTags, Folderable;

    protected $fillable = [
        'name',
        'description',
        'button',
        'folder_id',
        'position',
        'color',
    ];

    protected $appends = ['tags'];
}
