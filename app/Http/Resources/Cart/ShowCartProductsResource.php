<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCartProductsResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product_name' => $this->Product->name,
            'product_image' => \url('storage'.$this->Product->ProductImages[0]->image),
            'quantity' => $this->custom_quantity,
            'final_price' => $this->final_price,
        ];
    }
}
