<?php

declare(strict_types=1);

namespace App\Store\Domain\Enums;

enum ClientStatus: string
{
    case Active   = 'active';
    case Inactive = 'inactive';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::Active   => 'Activo',
            self::Inactive => 'Inactivo',
        };
    }
}
