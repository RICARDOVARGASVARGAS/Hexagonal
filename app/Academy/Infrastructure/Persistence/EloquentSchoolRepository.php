<?php

declare(strict_types=1);

namespace App\Academy\Infrastructure\Persistence;

use App\Academy\Domain\Entities\School;
use App\Academy\Domain\Repositories\SchoolRepository;
use App\Shared\Domain\Pagination\PaginationResult;

// Implementación del contrato SchoolRepository usando Eloquent
// Esta es la única clase en todo el sistema que conoce:
// - EloquentSchoolModel
// - PostgreSQL
// - SQL

final class EloquentSchoolRepository implements SchoolRepository
{
    // Inserta un School NUEVO en DB
    // Recibe: School entity con todos sus datos
    // Retorna: nada
    public function create(School $school): void
    {
        // toPrimitives() convierte la Entity a array simple
        // ['id' => 'uuid', 'name' => 'Colegio San Juan', 'status' => 'active', ...]
        EloquentSchoolModel::create($school->toPrimitives());
    }

    // Actualiza un School EXISTENTE en DB
    // Recibe: School entity con cambios aplicados
    // Retorna: nada
    public function update(School $school): void
    {
        // Busca el modelo por ID y actualiza solo name, status, updated_at
        EloquentSchoolModel::where('id', $school->id)
            ->update([
                'name'       => $school->name(),
                'status'     => $school->status()->value,
                'updated_at' => $school->updatedAt()->toDateTimeString(),
            ]);
    }

    // Busca un School por ID
    // Recibe: string uuid
    // Retorna: School entity si existe, null si no existe
    public function findById(string $id): ?School
    {
        $model = EloquentSchoolModel::find($id);

        // Si no existe retorna null
        // El Handler decide qué hacer con ese null
        if ($model === null) {
            return null;
        }

        // Convierte el modelo Eloquent → Entity de dominio
        return $this->toEntity($model);
    }

    // Busca un School por nombre exacto
    // Recibe: string nombre
    // Retorna: School entity si existe, null si no existe
    public function findByName(string $name): ?School
    {
        $model = EloquentSchoolModel::where('name', $name)->first();

        if ($model === null) {
            return null;
        }

        return $this->toEntity($model);
    }

    // Retorna Schools paginados
    // Recibe: parámetros de paginación y búsqueda
    // Retorna: PaginationResult con Schools y metadata
    public function paginate(
        int     $page = 1,
        int     $perPage = 15,
        ?string $search = null,
        string  $orderBy = 'name',
        string  $orderDir = 'asc',
    ): PaginationResult {
        $query = EloquentSchoolModel::query();

        // Si hay búsqueda, filtra por nombre
        if ($search !== null) {
            $query->where('name', 'ilike', "%{$search}%");
        }

        // Ordena y pagina
        $result = $query
            ->orderBy($orderBy, $orderDir)
            ->paginate($perPage, ['*'], 'page', $page);

        // Convierte cada modelo Eloquent → Entity
        // y retorna el PaginationResult del dominio (sin LengthAwarePaginator)
        return new PaginationResult(
            data: array_map(
                fn($model) => $this->toEntity($model),
                $result->items()
            ),
            total: $result->total(),
            perPage: $result->perPage(),
            currentPage: $result->currentPage(),
            lastPage: $result->lastPage(),
        );
    }

    // Verifica si existe un School por ID sin traer toda la entidad
    // Recibe: string uuid
    // Retorna: true si existe, false si no
    public function exists(string $id): bool
    {
        return EloquentSchoolModel::where('id', $id)->exists();
    }

    // Elimina un School por ID
    // Recibe: string uuid
    // Retorna: nada
    public function delete(string $id): void
    {
        EloquentSchoolModel::where('id', $id)->delete();
    }

    // Convierte un EloquentSchoolModel → School Entity
    // Método privado: solo este Repository sabe cómo hacer esta conversión
    // Recibe: EloquentSchoolModel
    // Retorna: School entity
    private function toEntity(EloquentSchoolModel $model): School
    {
        return School::fromPrimitives(
            id: $model->id,
            name: $model->name,
            status: $model->status,
            createdAt: $model->created_at->toDateTimeString(),
            updatedAt: $model->updated_at->toDateTimeString(),
        );
    }
}
