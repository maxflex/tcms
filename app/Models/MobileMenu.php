<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileMenu extends Model
{
    public $timestamps = false;
    protected $table = 'mobile_menu';
    protected $with = ['children'];

    protected $fillable = [
        'menu_id', 'title', 'extra', 'position', 'is_link', 'section_id'
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'menu_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'menu_id')->orderBy('position', 'asc');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->position = self::where('menu_id', $model->menu_id)->max('position') + 1;
        });
    }
}
