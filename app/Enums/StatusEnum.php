<?php
namespace App\Enums;

enum StatusEnum: int
{
    case ACTIVE = 1;
    case INACTIVE = 0;
    case DRAFT = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
 
    public static function getList(): array
    {
        return array_map(function (StatusEnum $status) {
            return [
                'key'   => $status->value,
                'name'  => self::getLang()[$status->value][app()->getLocale()]
            ];
        }, self::cases());
    }

    private static function getLang(): array
    {
        return  [
            self::ACTIVE->value => [
                'ru' => 'Активный',
                'en' => 'Active',
                'uz' => 'Aktiv'
            ],
            self::INACTIVE->value => [
                'ru' => 'Не активный',
                'en' => 'Inactive',
                'uz' => 'Aktiv emas'
            ],
            self::DRAFT->value => [
                'ru' => 'Черновик',
                'en' => 'Draft',
                'uz' => 'Kutilmoqda'
            ]
        ];
    }
}

