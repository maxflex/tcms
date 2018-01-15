<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPhotos;

class Equipment extends Model
{
    use HasPhotos;

    protected $fillable = [
        'name',
        'description',
        'button'
    ];
}
