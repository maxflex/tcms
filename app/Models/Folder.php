<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = ['name', 'class', 'position', 'folder_id'];
    protected $appends = ['item_count', 'folder_count'];

    public function getItemCountAttribute()
    {
        $class = $this->class;
        return $class::where('folder_id', $this->id)->count();
    }

    public function getFolderCountAttribute()
    {
        return self::where('folder_id', $this->id)->count();
    }
}
