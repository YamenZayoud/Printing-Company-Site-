<?php

namespace App\Http\Resources\NormalAttribute;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowNormalAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_by' => $this->Admin->name,
            'name' => $this->name,
        ];
    }
}
