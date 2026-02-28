<?php

declare(strict_types=1);

namespace App\Academy\Application\School\Delete;

// COMMAND: solo necesita el ID para eliminar
final class DeleteSchoolCommand
{
    public function __construct(
        public readonly string $id,
    ) {}
}
