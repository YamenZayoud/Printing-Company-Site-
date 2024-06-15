<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\CategoryAttributes\BinderyAttributesResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCategoryResource extends JsonResource
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
            'image' => \url('storage/'.$this->image),
            'is_active' => $this->is_active,
            'bindery_att' => [$this->bindery_att],
            'normal_att' => [$this->normal_att],
   ]; }
}
