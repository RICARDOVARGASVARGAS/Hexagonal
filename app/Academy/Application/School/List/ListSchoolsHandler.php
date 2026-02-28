<?php

declare(strict_types=1);

namespace App\Academy\Application\School\List;

use App\Academy\Domain\Repositories\SchoolRepository;
use App\Shared\Domain\Pagination\PaginationResult;

// HANDLER: caso de uso Listar Schools paginados
final class ListSchoolsHandler
{
    public function __construct(
        private readonly SchoolRepository $repository,
    ) {}

    // Recibe: ListSchoolsQuery con parámetros de paginación
    // Retorna: PaginationResult con Schools y metadata de paginación
    public function __invoke(ListSchoolsQuery $query): PaginationResult
    {
        return $this->repository->paginate(
            page: $query->page,
            perPage: $query->perPage,
            search: $query->search,
            orderBy: $query->orderBy,
            orderDir: $query->orderDir,
        );
    }
}
