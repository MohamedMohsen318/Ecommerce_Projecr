<?php

namespace App\Enums;

enum ItemStatus: string{
    case Available = 'available';
    case Unavailable = 'unavailable';
    case OutOfStock = 'out_of_stock';
    public function label(): string{
        return match ($this) {
            self::Available => 'Available',
            self::Unavailable => 'Unavailable',
            self::OutOfStock => 'Out of stock',
        };
    }
    public static function values(): array{
        return array_column(self::cases(), 'value');
    }
}
