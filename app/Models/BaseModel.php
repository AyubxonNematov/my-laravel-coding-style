<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BaseModel extends Model
{
    use HasTranslations;

    public function getTranslatableAttributes(): array
    {
        // Return an empty array if the 'accept-language' header is not present
        return request()->hasHeader('accept-language') ? ($this->translatable ?? []) : [];
    }
}
