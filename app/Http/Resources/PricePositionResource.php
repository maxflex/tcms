<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PricePositionResource extends JsonResource
{
    public function toArray($request)
    {
        return extract_fields($this, [
            'name', 'price', 'unit', 'tags'
        ]);
    }
}
