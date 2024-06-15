<?php

namespace App\Http\Resources\Quote;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOneQuoteResource extends JsonResource
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
            'user_name' => $this->User->display_name,
            'user_email' => $this->User->email,
            'product_id' => $this->product_id,
            'product_name' => $this->Product->name,
            'product_description' => $this->Product->description,
            'quantity_id' => $this->quantity_id,
            'product_quantity' => $this->Custom_quantity,
            'quote_price' => $this->quote_price,
            'user_expected_price' => $this->expected_price,
            'user_description' => $this->description,
            'work_days_id' => $this->work_days_id,
            'work_days_name' => $this->WorkDays->key,
            'bindery_att' => ShowQuoteBinderyOptionResource::collection($this->QuoteBinderyOptions),
            'normal_att' => ShowQuoteNormalOptionResource::collection($this->QuoteNormalOptions),

        ];
    }
}
