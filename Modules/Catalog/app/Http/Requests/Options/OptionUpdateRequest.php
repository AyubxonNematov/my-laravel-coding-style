<?php

namespace Modules\Catalog\Http\Requests\Options;

use Illuminate\Foundation\Http\FormRequest;

class OptionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "value" =>  ['nullable', 'string'],
            "filter" =>  ['nullable', 'boolean'],
            "specification_id" => ['nullable', 'string', 'exists:specifications,id'],
        ];
    }
}
