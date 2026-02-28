<?php

declare(strict_types=1);

namespace App\Academy\Application\School\Update;

// COMMAND: sobre con datos para actualizar un School
final class UpdateSchoolCommand
{
    public function __construct(
        public readonly string $id,    // para encontrarlo
        public readonly string $name,  // nuevo valor
    ) {}
}