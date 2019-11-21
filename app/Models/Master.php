<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\{HasPhotos, HasTags};

class Master extends Model
{
    use HasPhotos;
    use HasTags;

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'description',
        'video',
        'tags'
    ];

    public $appends = ['tags'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    public function scopeLight($query)
    {
        return $query->selectRaw("id, concat(last_name, ' ', left(first_name, 1), '. ', left(middle_name, 1), '.') as name");
    }
}
