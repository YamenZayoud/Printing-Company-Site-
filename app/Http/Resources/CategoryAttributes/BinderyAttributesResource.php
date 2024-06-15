<?php

namespace App\Http\Resources\CategoryAttributes;

use App\Models\CategoryBinderyOption;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BinderyAttributesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->BinderyAttribute->id,
            'name' => $this->BinderyAttribute->name,
            'attribute_type' => $this->BinderyAttribute->attribute_type,
            'att_options' => BinderyOptionsResource::collection($this->CategoryBinderyOptions),

        ];
    }
}
