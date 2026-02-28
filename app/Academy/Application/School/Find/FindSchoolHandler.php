<?php

declare(strict_types=1);

namespace App\Academy\Application\School\Find;

use App\Academy\Domain\Entities\School;
use App\Academy\Domain\Exceptions\SchoolNotFoundException;
use App\Academy\Domain\Repositories\SchoolRepository;

// HANDLER: caso de uso Buscar School por ID
final class FindSchoolHandler
{
    public function __construct(
        private readonly SchoolRepository $repository,
    ) {}

    // Recibe: FindSchoolQuery
    // Retorna: School entity (no array, no modelo Eloquent)
    // Lanza: SchoolNotFoundException si no existe
    public function __invoke(FindSchoolQuery $query): School
    {
        $school = $this->repository->findById($query->id);

        if ($school === null) {
            throw SchoolNotFoundException::withId($query->id);
        }

        return $school;
    }
}
