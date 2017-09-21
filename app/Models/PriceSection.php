<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceSection extends Model
{
    protected $fillable = [
        'name',
        'price_section_id'
    ];
    protected $with = ['positions', 'sections'];

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
     public function getItems()
     {
         $items = [];

         $top_level_sections = PriceSection::whereNull('price_section_id')->get();

         foreach($top_level_sections as $top_level_section) {
             $new_item = [
                 'model'        => $top_level_section,
                 'is_section'   => true,
                 'position'     => $top_level_section->position,
             ];
         }
     }

    /**
     * Обновить цену у раздела
     */
    public static function changePrice($data)
    {
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
            PricePosition::whereId($position->id)->update([
                'price' => $new_price
            ]);
        }
    }
}
