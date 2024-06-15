<?php

namespace App\Http\Resources\CategoryAttributes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NormalOptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->NormalOption->id,
            'name' => $this->NormalOption->name,
            'price_type' => $this->NormalOption->price_type,
            'flat_price' => $this->NormalOption->flat_price,
            'formula_price' => $this->NormalOption->formula_price,
        ];
    }
}
