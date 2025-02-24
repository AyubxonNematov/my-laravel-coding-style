<?php

namespace Modules\Catalog\Http\Resources\Options;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Http\Resources\Specifications\SpecificationFullResource;

class OptionFullResource extends JsonResource
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
            'value' => $this->value,
            'filter' => $this->filter,
            'specification' => new SpecificationFullResource($this->whenLoaded('specification')),
        ];
    }
}
