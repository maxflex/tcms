<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTags;

class Video extends Model
{
    use HasTags;

    protected $fillable = ['code', 'title', 'tags', 'master_id', 'position'];
    protected $appends = ['tags'];
}
