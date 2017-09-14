<?php

namespace App\Traits;

use App\Models\Photo;

trait HasPhotos
{
    public function photos()
    {
        return $this->morphMany(Photo::class, 'entity');
    }
}
