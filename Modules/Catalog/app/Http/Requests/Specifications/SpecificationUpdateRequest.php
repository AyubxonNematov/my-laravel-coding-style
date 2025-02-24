<?php

namespace Modules\Catalog\Http\Requests\Specifications;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Catalog\Enum\SpecificationTypeEnum;

class SpecificationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" =>  ['nullable', 'array'],
            "name.uz" =>  ['nullable', 'string', 'unique:specifications,name->uz'],
            "name.ru" =>  ['nullable', 'string', 'unique:specifications,name->ru'],
            "name.en" =>  ['nullable', 'string', 'unique:specifications,name->en'],
            "type" =>  ['nullable', 'string', 'in:'.implode(',', SpecificationTypeEnum::values())],
            "filter" =>  ['nullable', 'boolean'],
            "position" =>  ['nullable', 'numeric'],
            "leaf_category_id" => ['nullable', 'string', 'exists:categories,id'],
        ];
    }
}
