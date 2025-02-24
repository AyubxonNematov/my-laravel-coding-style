<?php

namespace Modules\Catalog\Http\Requests\Options;

use Illuminate\Foundation\Http\FormRequest;

class OptionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "value" =>  ['required', 'string'],
            "filter" =>  ['required', 'boolean'],
            "specification_id" => ['required', 'string', 'exists:specifications,id'],
        ];
    }
}
