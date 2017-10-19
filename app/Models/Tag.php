<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $visible = ['id', 'text'];
    protected $fillable = ['text', 'position'];
}
