<?php

declare(strict_types=1);

namespace App\Shared\Domain\Pagination;

// Objeto de paginación propio del dominio
// No depende de Laravel ni de ningún framework
final class PaginationResult
{
    public function __construct(
        public readonly array $data,         // items de la página actual
        public readonly int   $total,        // total de registros
        public readonly int   $perPage,      // items por página
        public readonly int   $currentPage,  // página actual
        public readonly int   $lastPage,     // última página
    ) {}

    // Recibe: nada
    // Retorna: true si hay más páginas, false si es la última
    public function hasMorePages(): bool
    {
        return $this->currentPage < $this->lastPage;
    }

    // Recibe: nada
    // Retorna: true si es la primera página
    public function isFirstPage(): bool
    {
        return $this->currentPage === 1;
    }

    // Recibe: nada
    // Retorna: true si es la última página
    public function isLastPage(): bool
    {
        return $this->currentPage === $this->lastPage;
    }
}
