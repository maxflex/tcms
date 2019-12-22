<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuSection extends Model
{
    protected $fillable = ['title', 'position', 'type', 'is_link', 'extra', 'is_hidden'];

    protected $with = ['items'];

    public $timestamps = false;

    public function items()
    {
        return $this->hasMany(Menu::class, 'section_id')->whereNull('menu_id')->orderBy('position', 'asc');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->position = self::max('position') + 1;
        });
    }
}
