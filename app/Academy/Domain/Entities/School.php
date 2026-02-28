<?php

declare(strict_types=1);

namespace App\Academy\Domain\Entities;

use App\Academy\Domain\Enums\SchoolStatus;
use Carbon\Carbon;


// LA REGLA DE NEGOCIO VA AQUÍ
final class School
{
    // Constructor privado: solo los factory methods pueden crear una School
    private function __construct(
        public readonly string  $id,
        private string          $name,
        private SchoolStatus    $status,
        public readonly Carbon  $createdAt,
        private Carbon          $updatedAt
    ) {}


    // Para crear un School NUEVO desde el sistema
    // Recibe: id generado, nombre
    // Retorna: School con status Active y fechas actuales
    public static function create(
        string  $id,
        string  $name,
    ): self {
        return new self(
            id: $id,
            name: $name,
            status: SchoolStatus::Active,
            createdAt: Carbon::now(),
            updatedAt: Carbon::now()
        );
    }

    // Para RECONSTITUIR un School que ya existe en DB
    // Recibe: datos crudos de Eloquent
    // Retorna: School con valores exactos de DB, sin pisar fechas
    public static function fromPrimitives(
        string $id,
        string $name,
        string $status,
        string $createdAt,
        string $updatedAt,
    ): self {
        return new self(
            id: $id,
            name: $name,
            status: SchoolStatus::from($status),
            createdAt: Carbon::parse($createdAt),
            updatedAt: Carbon::parse($updatedAt),
        );
    }

    // Actualiza el nombre del School
    // Recibe: nuevo nombre
    // Retorna: nada, actualiza updatedAt automáticamente
    public function update(string $name): void
    {
        $this->name =       $name;
        $this->updatedAt =  Carbon::now();
    }

    // Activa el School
    // Recibe: nada
    // Retorna: nada
    public function activate(): void
    {
        $this->status    = SchoolStatus::Active;
        $this->updatedAt = Carbon::now();
    }

    // Desactiva el School
    // Recibe: nada
    // Retorna: nada
    public function deactivate(): void
    {
        $this->status    = SchoolStatus::Inactive;
        $this->updatedAt = Carbon::now();
    }

    // Recibe: nada | Retorna: 'Colegio San Juan'
    public function name(): string
    {
        return $this->name;
    }

    // Recibe: nada | Retorna: SchoolStatus::Active
    public function status(): SchoolStatus
    {
        return $this->status;
    }

    // Recibe: nada | Retorna: true o false
    public function isActive(): bool
    {
        return $this->status === SchoolStatus::Active;
    }

    // Recibe: nada | Retorna: Carbon instance
    public function updatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    // Convierte la entidad a primitivos para que Eloquent pueda persistirla
    // Recibe: nada
    // Retorna: array con strings e ints, sin objetos
    public function toPrimitives(): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'status'     => $this->status->value,
            'created_at' => $this->createdAt->toDateTimeString(),
            'updated_at' => $this->updatedAt->toDateTimeString(),
        ];
    }
}
