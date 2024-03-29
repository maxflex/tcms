<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariableGroup extends Model
{
    protected $fillable = ['title', 'position'];

    public $timestamps = false;

    const DEFAULT_TITLE = 'Новая группа';

    public function variable()
    {
        return $this->hasMany(Variable::class, 'group_id')->orderBy('position');
    }

    public static function get()
    {
        return self::with('variable')->orderBy('position')->get()->all();
    }

    public static function booted()
    {
        static::creating(function ($model) {
            $model->title = self::DEFAULT_TITLE;
            $model->position = static::max('position') + 1;
        });
    }
}
