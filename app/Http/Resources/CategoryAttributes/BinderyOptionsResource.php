<?php

namespace App\Http\Resources\CategoryAttributes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BinderyOptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->BinderyOption->id,
            'name' => $this->BinderyOption->name,
            'setup_price' => $this->BinderyOption->setup_price,
            'price_per_unit' => $this->BinderyOption->price_per_unit,
            'markup' => $this->BinderyOption->markup,
        ];
    }
}
