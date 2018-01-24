<?php

namespace App\Traits;

use App\Models\Folder;

trait HasFolders
{
    public function photos()
    {
        return $this->morphMany(Photo::class, 'entity');
    }
}
