<?php

declare(strict_types=1);

namespace App\Academy\Application\School\Create;

use App\Academy\Domain\Entities\School;
use App\Academy\Domain\Exceptions\SchoolAlreadyExistsException;
use App\Academy\Domain\Repositories\SchoolRepository;

// HANDLER: caso de uso Crear School
// Orquesta el dominio para cumplir esta tarea
// No sabe nada de Laravel, HTTP ni Eloquent
// Solo conoce Domain y Application

final class CreateSchoolHandler
{
    // Recibe la INTERFAZ del repositorio, no la implementación
    // El Service Provider inyecta EloquentSchoolRepository aquí
    public function __construct(
        private readonly SchoolRepository $repository,
    ) {}

    // __invoke: permite llamarlo como ($handler)($command)
    // Recibe: CreateSchoolCommand
    // Retorna: void porque es un Command, modifica estado
    // Lanza: SchoolAlreadyExistsException si el nombre ya existe
    public function __invoke(CreateSchoolCommand $command): void
    {
        // PASO 1: Verificar que no existe School con ese nombre
        $existing = $this->repository->findByName($command->name);

        if ($existing !== null) {
            throw SchoolAlreadyExistsException::withName($command->name);
        }


        // PASO 2: Crear la Entity con su factory method
        // create() controla el status inicial y las fechas automáticamente.
        $school = School::create(
            id: $command->id,
            name: $command->name
        );


        // PASO 3: Persistir usando la interfaz
        $this->repository->create($school);
    }
}



// final class CreateSchoolHandler
// {
//     // El Repository llega aquí automáticamente via Laravel
//     // En realidad es un EloquentSchoolRepository disfrazado
//     public function __construct(
//         private readonly SchoolRepository $repository,
//     ) {}

//     // Sin __invoke, usamos execute() como nombre del método
//     // Recibe: CreateSchoolCommand { id: 'uuid', name: 'Colegio San Juan' }
//     // Retorna: void
//     public function execute(CreateSchoolCommand $command): void
//     {
//         // PASO 1: pregunta al Repository si ya existe ese nombre en DB
//         // $existing = School si encontró algo, null si no encontró nada
//         $existing = $this->repository->findByName($command->name);

//         // Si encontró algo → para todo con excepción
//         if ($existing !== null) {
//             throw SchoolAlreadyExistsException::withName($command->name);
//         }

//         // PASO 2: crea el objeto School en memoria (todavía no va a DB)
//         // School::create() pone status=Active y fechas=ahora automáticamente
//         $school = School::create(
//             id:   $command->id,    // 'a1b2c3d4-e5f6-7890-abcd-ef1234567890'
//             name: $command->name,  // 'Colegio San Juan'
//         );
//         // $school ahora es un objeto School con todos sus datos
//         // Solo existe en memoria PHP, no en DB todavía

//         // PASO 3: entrega el objeto al Repository para que lo guarde
//         // El Handler no sabe CÓMO se guarda, solo dice "guárdalo"
//         // EloquentSchoolRepository hace el INSERT real en DB
//         $this->repository->create($school);
//     }
// }

// // ASÍ SE LLAMA sin __invoke:
// $handler->execute($command);

// // ASÍ SE LLAMA con __invoke:
// ($handler)($command);
// ```

// ---

// ## Los dos son idénticos en resultado
// ```
// Con __invoke:  ($handler)($command)    → más limpio, un solo propósito
// Sin __invoke:  $handler->execute()     → más explícito, más familiar

// Ambos hacen exactamente lo mismo.