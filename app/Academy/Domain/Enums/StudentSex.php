<?php

declare(strict_types=1);

namespace App\Academy\Domain\Enums;

enum StudentSex: string
{
    case Male   = 'male';
    case Female = 'female';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::Male   => 'Masculino',
            self::Female => 'Femenino',
        };
    }
}
