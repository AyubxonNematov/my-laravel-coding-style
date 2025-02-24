<?php

namespace Modules\Catalog\Http\Resources\Categories;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryShortResource extends JsonResource
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
            'children' => self::collection($this->whenLoaded('children')),
        ];
    }
}
