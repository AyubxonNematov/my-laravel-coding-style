<?php
namespace App\Enums;

enum GoodsTypeEnum: string
{
    case PRODUCT = 'product';
    case SPARE_PART = 'spare_part';
    case MERCH = 'merch';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getList(): array
    {
        return array_map(function (GoodsTypeEnum $type) {
            return [
                "key" => $type->value,
                "name" => self::getLang()[$type->value][app()->getLocale()]
            ];
        }, self::cases());
    }

    private static function getLang(): array
    {
        return [
            self::PRODUCT->value => [
                'ru' => 'Товар',
                'en' => 'Product',
                'uz' => 'Mahsulot'
            ],
            self::SPARE_PART->value => [
                'ru' => 'Запчасть',
                'en' => 'Spare Part',
                'uz' => 'Spare Part'
            ],
            self::MERCH->value => [
                'ru' => 'Мерч',
                'en' => 'Merch',
                'uz' => 'Merch'
            ]
        ];
    }
}

