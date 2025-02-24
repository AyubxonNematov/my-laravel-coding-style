<?php

namespace Modules\Catalog\Http\Resources\Specifications;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Http\Resources\Categories\CategoryShortResource;

class SpecificationFullResource extends JsonResource
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
            'type' => $this->type,
            'filter' => $this->filter,
            'position' => $this->position,
            'leaf_category' => new CategoryShortResource($this->whenLoaded('leaf_category')),
        ];
    }
}
