<?php

declare(strict_types=1);

namespace App\Academy\Application\School\Delete;

use App\Academy\Domain\Exceptions\SchoolNotFoundException;
use App\Academy\Domain\Repositories\SchoolRepository;

// HANDLER: caso de uso Eliminar School
final class DeleteSchoolHandler
{
    public function __construct(
        private readonly SchoolRepository $repository,
    ) {}

    // Recibe: DeleteSchoolCommand
    // Retorna: void
    // Lanza: SchoolNotFoundException si no existe
    public function __invoke(DeleteSchoolCommand $command): void
    {
        // PASO 1: verificar que existe antes de eliminar
        $school = $this->repository->findById($command->id);

        if ($school === null) {
            throw SchoolNotFoundException::withId($command->id);
        }

        // PASO 2: eliminar
        $this->repository->delete($command->id);
    }
}
