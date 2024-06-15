<?php

namespace App\Http\Resources\CategoryAttributes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NormalAttributesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->NormalAttribute->id,
            'name' => $this->NormalAttribute->name,
            'attribute_type' => $this->NormalAttribute->attribute_type,
            'att_options' => NormalOptionsResource::collection($this->CategoryNormalOptions),
        ];
    }
}
