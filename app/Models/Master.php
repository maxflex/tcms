<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPhotos;

class Master extends Model
{
    use HasPhotos;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'description',
        'video',
    ];

    public function scopeLight($query)
    {
        return $query->selectRaw("id, concat(last_name, ' ', left(first_name, 1), '. ', left(middle_name, 1), '.') as name");
    }
}
