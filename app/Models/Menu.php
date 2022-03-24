<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $timestamps = false;
    protected $table = 'menu';
    protected $with = ['children'];

    protected $fillable = [
        'menu_id', 'title', 'extra', 'position', 'is_link',
        'section_id', 'is_hidden', 'desc'
    ];

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function children()
    {
        return $this->hasMany(self::class)->orderBy('position', 'asc');
    }

    public static function booted()
    {
        static::creating(function ($model) {
            $model->position = self::where('menu_id', $model->menu_id)->max('position') + 1;
        });
    }
}
