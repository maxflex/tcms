<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceSection extends Model
{
    protected $fillable = [
        'name',
        'price_section_id',
        'position',
        'extra_column',
        'is_hidden',
    ];

    // protected $with = ['sections', 'positions'];

    // protected $appends = ['item'];

    public function positions()
    {
        return $this->hasMany(PricePosition::class)->orderBy('position');
    }

    public function sections()
    {
        return $this->hasMany(self::class);
    }

    /**
     *
     */
     public function getItemAttribute()
     {
         $items = [];

         foreach($this->sections as $section) {
             $items[] = [
                 'model'        => $section,
                 'is_section'   => true,
                 'items'        => $section->item['items'],
                 'position'     => $section->position,
                 'is_hidden' => $section->is_hidden,
             ];
         }
         foreach($this->positions as $position) {
             $items[] = [
                 'model'        => $position,
                 'is_section'   => false,
                 'position'     => $position->position,
             ];
         }

         usort($items, function($a, $b) {
             return $a['position'] - $b['position'];
         });

         return [
             'model' => $this,
             'is_section' => true,
             'items' => $items,
             'position' => $this->position,
             'is_hidden' => $this->is_hidden,
         ];
     }

     public function scopeTopLevel($query)
     {
         return $query->whereNull('price_section_id')->orderBy('position');
     }

    /**
     * Обновить цену у раздела
     */
    public static function changePrice($data)
    {
        if ($data->section_id == -1) {
            $top_level_section_ids = self::topLevel()->pluck('id');
            foreach($top_level_section_ids as $section_id) {
                $clone_data = clone $data;
                $clone_data->section_id = $section_id;
                self::changePrice($clone_data);
            }
        } else {
            $section = self::find($data->section_id);
            foreach($section->sections as $child_section) {
                $clone_data = clone $data;
                $clone_data->section_id = $child_section->id;
                self::changePrice($clone_data);
            }
            foreach($section->positions as $position) {
                if ($data->unit == 1) {
                    $coeff = $position->price * ($data->value / 100);
                } else {
                    $coeff = $data->value;
                }
                if ($data->type == 1) {
                    $new_price = $position->price - $coeff;
                } else {
                    $new_price = $position->price + $coeff;
                }
                PricePosition::find($position->id)->update([
                    'price' => round($new_price)
                ]);
            }
        }
    }
}
