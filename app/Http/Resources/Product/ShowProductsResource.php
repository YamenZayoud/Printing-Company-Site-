<?php

namespace App\Http\Resources\Product;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProductsResource extends JsonResource
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
            'category_name' => $this->Category->name,
            'name' => $this->name,
            'image' => $this->productImages[0] ? url('storage/'.$this->productImages[0]->image) : null,
            'rate' => \round(Rating::where('product_id',$this->id)->average('rating'),2) ?? 0,
            'is_active' => $this->is_active,
        ];
    }
}
