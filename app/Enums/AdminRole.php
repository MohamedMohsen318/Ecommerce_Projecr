<?php

namespace App\Enums;

enum AdminRole: string{
    case SuperAdmin = 'super-admin';
    case Editor = 'editor';
    public static function values(): array{
        return array_column(self::cases(), 'value');
    }
}
