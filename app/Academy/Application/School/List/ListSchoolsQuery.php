<?php

declare(strict_types=1);

namespace App\Academy\Application\School\List;

// QUERY: parámetros de paginación y búsqueda
// Valores por defecto para que el Controller no tenga que enviarlos siempre
final class ListSchoolsQuery
{
    public function __construct(
        public readonly int     $page = 1,
        public readonly int     $perPage = 15,
        public readonly ?string $search = null,
        public readonly string  $orderBy = 'name',
        public readonly string  $orderDir = 'asc',
    ) {}
}
