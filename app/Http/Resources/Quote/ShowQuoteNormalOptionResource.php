<?php

namespace App\Http\Resources\Quote;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowQuoteNormalOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'att_id' => $this->NormalOption->NormalAttribute->id,
            'att_name' => $this->NormalOption->NormalAttribute->name,
            'att_option_id' => $this->NormalOption->id,
            'att_option_name' => $this->NormalOption->name,
            'value' => $this->value,
        ];
    }
}
