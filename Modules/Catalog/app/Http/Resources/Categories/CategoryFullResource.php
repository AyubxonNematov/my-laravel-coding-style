<?php

namespace Modules\Catalog\Http\Resources\Categories;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryFullResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'photo' => $this->photo,
            'photo_focus' => $this->photo_focus,
            'coefficient' => $this->coefficient,
            'coefficient_commissioner' => $this->coefficient_commissioner,
            'coefficient_extra' => $this->coefficient_extra,
            'status' => $this->status,
            'type' => $this->type,
            'position' => $this->position,
            'children' => self::collection($this->whenLoaded('children')), 
            'parent_id' => $this->parent_id,
        ];
    }
}
