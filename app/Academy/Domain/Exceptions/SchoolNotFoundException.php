<?php

declare(strict_types=1);

namespace App\Academy\Domain\Exceptions;

use RuntimeException;

// Excepción de dominio: School no encontrado en el sistema
// RuntimeException porque es un caso esperado en tiempo de ejecución
// no un bug de programación

final class SchoolNotFoundException extends RuntimeException
{
    // Factory method: cuando buscas por ID y no existe
    // Recibe: '9d4e8f2a-1b3c-4d5e-6f7a-8b9c0d1e2f3a'
    // Retorna: SchoolNotFoundException con mensaje claro
    // Uso: throw SchoolNotFoundException::withId($id)
    public static function withId(string $id): self
    {
        return new self(
            "School with ID '{$id}' was not found."
        );
    }

    // Factory method: cuando buscas por nombre y no existe
    // Recibe: 'Colegio San Juan'
    // Retorna: SchoolNotFoundException con mensaje claro
    // Uso: throw SchoolNotFoundException::withName($name)
    public static function withName(string $name): self
    {
        return new self(
            "School with name '{$name}' was not found."
        );
    }
}
