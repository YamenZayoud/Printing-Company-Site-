<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\Quote\ShowQuoteBinderyOptionResource;
use App\Http\Resources\Quote\ShowQuoteNormalOptionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOneCartProductResource extends JsonResource
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
            'user_name' => $this->Cart->User->display_name,
            'user_email' => $this->Cart->User->email,
            'product_id' => $this->product_id,
            'product_name' => $this->Product->name,
            'product_description' => $this->Product->description,
            'quantity_id' => $this->quantity_id,
            'product_quantity' => $this->custom_quantity,
            'final_price' => $this->final_price,
            'work_days_id' => $this->work_days_id,
            'work_days_name' => $this->WorkDays->key,
           'bindery_att' => ShowCartProductBinderyOptionResource::collection($this->CartProductBinderyOptions),
            'normal_att' => ShowCartProductNormalOptionResource::collection($this->CartProductNormalOptions),

        ];
    }
}
