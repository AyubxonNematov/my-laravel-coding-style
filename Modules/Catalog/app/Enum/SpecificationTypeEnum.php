<?php

namespace Modules\Catalog\Enum;

enum SpecificationTypeEnum: string
{
    case DROPDOWN = 'dropdown';
    case CHECKBOX_MULTIPLE = 'checkbox_multiple';
    case FREE = 'free';
    case RANGE = 'range';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
