<?php

namespace Modules\Catalog\Http\Requests\Categories;

use App\Enums\StatusEnum;
use App\Enums\GoodsTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" =>  ['nullable', 'array'],
            "name.uz" =>  ['nullable', 'string', Rule::unique('categories', 'name->uz')->ignore($this->category)],
            "name.ru" =>  ['nullable', 'string', Rule::unique('categories', 'name->ru')->ignore($this->category)],
            "name.en" =>  ['nullable', 'string', Rule::unique('categories', 'name->en')->ignore($this->category)],
            "parent_id" =>  ['nullable', 'string', 'exists:categories,id'],
            "icon" =>  ['nullable', 'array'],
            "icon.id" =>  ['nullable'],
            "icon.original" =>  ['nullable', 'url'],
            "icon.large" =>  ['nullable', 'url'],
            "icon.medium" =>  ['nullable', 'url'],
            "icon.small" =>  ['nullable', 'url'],
            "photo" =>  ['nullable', 'array'],
            "photo.*.id" =>  ['nullable'],
            "photo.*.original" =>  ['nullable', 'url'],
            "photo.*.large" =>  ['nullable', 'url'],
            "photo.*.medium" =>  ['nullable', 'url'],
            "photo.*.small" =>  ['nullable', 'url'],
            "photo_focus" =>  ['nullable', 'array'],
            "photo_focus.id" =>  ['nullable'],
            "photo_focus.original" =>  ['nullable', 'url'],
            "photo_focus.large" =>  ['nullable', 'url'],
            "photo_focus.medium" =>  ['nullable', 'url'],
            "photo_focus.small" =>  ['nullable', 'url'],
            "type" =>  ['nullable', 'string', 'in:'.implode(',', GoodsTypeEnum::values())],
            "status" =>  ['nullable', 'numeric', "in:". implode(',', StatusEnum::values())],
            "coefficient" =>  ['nullable', 'numeric', 'max:50'],
            "coefficient_commissioner" => ['nullable', 'numeric', 'max:50'],
            "coefficient_extra" => ['nullable', 'numeric', 'max:50'],
            "position" =>  ['nullable', 'numeric'],
        ];
    }
}
