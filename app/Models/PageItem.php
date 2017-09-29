<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'page_id',
        'href_page_id',
        'title',
        'description',
        'file'
    ];
    
}
