<?php

namespace App\Http\Resources\Quote;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowQuoteBinderyOptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'att_id' => $this->BinderyOption->BinderyAttribute->id,
            'att_name' => $this->BinderyOption->BinderyAttribute->name,
            'att_option_id' => $this->BinderyOption->id,
            'att_option_name' => $this->BinderyOption->name,
            'value' => $this->value,
        ];
    }
}
