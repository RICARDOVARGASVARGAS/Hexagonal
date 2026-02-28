<?php

declare(strict_types=1);

namespace App\Academy\Application\School\Update;

use App\Academy\Domain\Exceptions\SchoolAlreadyExistsException;
use App\Academy\Domain\Exceptions\SchoolNotFoundException;
use App\Academy\Domain\Repositories\SchoolRepository;

// HANDLER: caso de uso Actualizar School
final class UpdateSchoolHandler
{
    public function __construct(
        private readonly SchoolRepository $repository,
    ) {}

    // Recibe: UpdateSchoolCommand
    // Retorna: void
    // Lanza: SchoolNotFoundException si no existe
    //        SchoolAlreadyExistsException si el nuevo nombre ya lo usa otro
    public function __invoke(UpdateSchoolCommand $command): void
    {
        // PASO 1: verificar que el School existe
        $school = $this->repository->findById($command->id);

        if ($school === null) {
            throw SchoolNotFoundException::withId($command->id);
        }

        // PASO 2: verificar que el nuevo nombre no lo use otro School
        $existing = $this->repository->findByName($command->name);

        // $existing->id !== $command->id porque puede ser el mismo School
        // actualizando con el mismo nombre que ya tiene
        if ($existing !== null && $existing->id !== $command->id) {
            throw SchoolAlreadyExistsException::withName($command->name);
        }

        // PASO 3: aplicar el cambio en la Entity
        // update() actualiza updatedAt automáticamente
        $school->update($command->name);

        // PASO 4: persistir
        $this->repository->update($school);
    }
}
