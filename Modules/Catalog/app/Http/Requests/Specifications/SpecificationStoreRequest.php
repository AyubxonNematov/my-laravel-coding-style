<?php

namespace Modules\Catalog\Http\Requests\Specifications;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Catalog\Enum\SpecificationTypeEnum;

class SpecificationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" =>  ['required', 'array'],
            "name.uz" =>  ['required', 'string', 'unique:specifications,name->uz'],
            "name.ru" =>  ['required', 'string', 'unique:specifications,name->ru'],
            "name.en" =>  ['required', 'string', 'unique:specifications,name->en'],
            "type" =>  ['required', 'string', 'in:'.implode(',', SpecificationTypeEnum::values())],
            "filter" =>  ['required', 'boolean'],
            "position" =>  ['required', 'numeric'],
            "leaf_category_id" => ['required', 'string', 'exists:categories,id'],
        ];
    }
}
