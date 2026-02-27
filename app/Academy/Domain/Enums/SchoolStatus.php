<?php

declare(strict_types=1);

namespace App\Academy\Domain\Enums;

enum SchoolStatus: string
{
    case Active    = 'active';
    case Inactive  = 'inactive';
    case Suspended = 'suspended';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::Active    => 'Activo',
            self::Inactive  => 'Inactivo',
            self::Suspended => 'Suspendido',
        };
    }
}
