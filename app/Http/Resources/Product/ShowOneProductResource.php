<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\CategoryAttributes\BinderyAttributesResource;
use App\Http\Resources\CategoryAttributes\NormalAttributesResource;
use App\Http\Resources\WorkDays\ShowWorkDaysResource;
use App\Models\Rating;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowOneProductResource extends JsonResource
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
            'category_id' => $this->category_id,
            'category_name' => $this->Category->name,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'rate' => \round(Rating::where('product_id', $this->id)->average('rating'), 2) ?? 0,
            'bindery_att' => BinderyAttributesResource::collection($this->Category->CategoryBinderyAttributes),
            'normal_att' => NormalAttributesResource::collection($this->Category->CategoryNormalAttributes),
            'quantities' => $this->ProductQuantities()->Order()->get(),
            'work_days' => ShowWorkDaysResource::collection(Setting::where('description','$ work $ days $')->get()),
        ];
    }
}
