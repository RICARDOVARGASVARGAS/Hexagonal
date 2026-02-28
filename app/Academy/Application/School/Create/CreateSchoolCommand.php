<?php

declare(strict_types=1);

namespace App\Academy\Application\School\Create;

// COMMAND: sobre con datos para crear un School
// PHP puro, sin Laravel, sin Eloquent
// El Controller lo crea con datos ya validados por FormRequest
// Solo transporta datos, no tiene lógica

final class CreateSchoolCommand
{
    public function __construct(
        // ID generado en el Controller antes de llamar al Handler
        // Así el Controller conoce el ID antes de que se persista
        public readonly string $id,
        public readonly string $name,
    ) {}
}
