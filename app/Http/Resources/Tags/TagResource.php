<?php

namespace App\Http\Resources\Tags;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'product_id' => $this->Product->id,
            'product_name' => $this->Product->name,
            'product_description' => $this->Product->description,
        ];
    }
}
