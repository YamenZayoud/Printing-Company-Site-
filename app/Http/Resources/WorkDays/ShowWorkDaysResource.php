<?php

namespace App\Http\Resources\WorkDays;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowWorkDaysResource extends JsonResource
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
            'name' => $this->key,
            'value' => (double)$this->value,
        ];
    }
}
