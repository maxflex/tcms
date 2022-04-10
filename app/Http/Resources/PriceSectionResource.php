<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceSectionResource extends JsonResource
{
    public function toArray($request)
    {
        return extract_fields($this, [
            'name', 'positions_count', 'sections_count', 'is_hidden'
        ]);
    }
}
