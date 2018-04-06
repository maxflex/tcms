<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPhotos;
use App\Traits\Folderable;

class Equipment extends Model
{
    use HasPhotos, Folderable;

    protected $fillable = [
        'name',
        'description',
        'button',
        'folder_id',
        'position',
        'color'
    ];
}
