<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    const ALLOWED_TAGS = ['p', 'br', 'ul', 'li', 'a', 'h3'];
    protected $visible = ['id', 'text'];
    protected $fillable = ['text', 'position'];
}
