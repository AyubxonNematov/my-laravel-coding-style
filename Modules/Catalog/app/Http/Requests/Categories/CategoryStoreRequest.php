<?php

namespace Modules\Catalog\Http\Requests\Categories;

use App\Enums\StatusEnum;
use App\Enums\GoodsTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" =>  ['required', 'array'],
            "name.uz" =>  ['required', 'string', 'unique:categories,name->uz'],
            "name.ru" =>  ['required', 'string', 'unique:categories,name->ru'],
            "name.en" =>  ['required', 'string', 'unique:categories,name->en'],
            "parent_id" =>  ['nullable', 'string', 'exists:categories,id'],
            "icon" =>  ['required', 'array'],
            "icon.id" =>  ['required'],
            "icon.original" =>  ['required', 'url'],
            "icon.large" =>  ['required', 'url'],
            "icon.medium" =>  ['required', 'url'],
            "icon.small" =>  ['required', 'url'],
            "photo" =>  ['required', 'array'],
            "photo.*.id" =>  ['required'],
            "photo.*.original" =>  ['required', 'url'],
            "photo.*.large" =>  ['required', 'url'],
            "photo.*.medium" =>  ['required', 'url'],
            "photo.*.small" =>  ['required', 'url'],
            "photo_focus" =>  ['required', 'array'],
            "photo_focus.id" =>  ['required'],
            "photo_focus.original" =>  ['required', 'url'],
            "photo_focus.large" =>  ['required', 'url'],
            "photo_focus.medium" =>  ['required', 'url'],
            "photo_focus.small" =>  ['required', 'url'],
            "type" =>  ['required', 'string', 'in:'.implode(',', GoodsTypeEnum::values())],
            "status" =>  ['required','numeric', "in:". implode(',', StatusEnum::values())],
            "coefficient" =>  ['required', 'numeric', 'max:50'],
            "coefficient_commissioner" => ['required', 'numeric', 'max:50'],
            "coefficient_extra" => ['required', 'numeric', 'max:50'],
            "position" =>  ['required', 'numeric'],
        ];
    }
}
