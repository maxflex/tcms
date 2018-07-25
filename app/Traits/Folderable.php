<?php

namespace App\Traits;

use App\Models\Folder;
use App\Scopes\DraggableScope;

trait Folderable
{
    public function scopeSearchByFolder($query, $folder_id)
    {
        if ($folder_id) {
            $query->where('folder_id', $folder_id);
        } else {
            $query->whereNull('folder_id');
        }
        return $query;
    }

    public function scopeOrderByPosition($query)
    {
        return $query->orderBy('position', 'asc')->orderBy('id', 'asc');
    }
}
