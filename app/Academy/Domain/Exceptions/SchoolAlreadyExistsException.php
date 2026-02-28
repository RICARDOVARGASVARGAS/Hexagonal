<?php

declare(strict_types=1);

namespace App\Academy\Domain\Exceptions;

use RuntimeException;

// Excepción de dominio: intento de crear un School con nombre duplicado
// RuntimeException porque es un caso esperado en tiempo de ejecución
final class SchoolAlreadyExistsException extends RuntimeException
{
    // Factory method: cuando intentas crear un School con nombre que ya existe
    // Recibe: 'Colegio San Juan'
    // Retorna: SchoolAlreadyExistsException con mensaje claro
    // Uso: throw SchoolAlreadyExistsException::withName($name)
    public static function withName(string $name): self
    {
        return new self(
            "School with name '{$name}' already exists."
        );
    }
}
