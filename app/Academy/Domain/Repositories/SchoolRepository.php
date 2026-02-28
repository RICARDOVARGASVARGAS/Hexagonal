<?php

declare(strict_types=1);

namespace App\Academy\Domain\Repositories;

use App\Academy\Domain\Entities\School;
use App\Shared\Domain\Pagination\PaginationResult;

// INTERFAZ: define QUÉ operaciones necesita el dominio
// No sabe CÓMO se implementan, no sabe que existe Eloquent ni PostgreSQL
// Es el CONTRATO entre el dominio y la infraestructura

interface SchoolRepository
{
    // Persiste un School NUEVO en la base de datos
    // Recibe: School entity recién creada
    // Retorna: nada
    public function create(School $school): void;

    // Actualiza un School EXISTENTE en la base de datos
    // Recibe: School entity con cambios aplicados
    // Retorna: nada
    public function update(School $school): void;

    // Busca un School por su ID
    // Recibe: string uuid
    // Retorna: School si existe, null si no existe
    public function findById(string $id): ?School;

    // Busca un School por nombre exacto
    // Recibe: string nombre
    // Retorna: School si existe, null si no existe
    public function findByName(string $name): ?School;

    // Retorna Schools paginados con búsqueda y ordenamiento opcionales
    public function paginate(
        int     $page = 1,
        int     $perPage = 15,
        ?string $search = null,
        string  $orderBy = 'name',
        string  $orderDir = 'asc',
    ): PaginationResult;

    // Verifica si un School existe por ID sin traer toda la entidad
    // Recibe: string uuid
    // Retorna: true si existe, false si no
    public function exists(string $id): bool;

    // Elimina un School por su ID
    // Recibe: string uuid
    // Retorna: nada
    public function delete(string $id): void;
}
