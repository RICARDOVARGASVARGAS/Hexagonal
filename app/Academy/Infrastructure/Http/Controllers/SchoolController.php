<?php

declare(strict_types=1);

namespace App\Academy\Infrastructure\Http\Controllers;

use App\Academy\Application\School\Create\CreateSchoolCommand;
use App\Academy\Application\School\Create\CreateSchoolHandler;
use App\Academy\Application\School\Delete\DeleteSchoolCommand;
use App\Academy\Application\School\Delete\DeleteSchoolHandler;
use App\Academy\Application\School\Find\FindSchoolQuery;
use App\Academy\Application\School\Find\FindSchoolHandler;
use App\Academy\Application\School\List\ListSchoolsQuery;
use App\Academy\Application\School\List\ListSchoolsHandler;
use App\Academy\Application\School\Update\UpdateSchoolCommand;
use App\Academy\Application\School\Update\UpdateSchoolHandler;
use App\Academy\Domain\Exceptions\SchoolAlreadyExistsException;
use App\Academy\Domain\Exceptions\SchoolNotFoundException;
use App\Academy\Infrastructure\Http\Requests\SchoolRequest;
use App\Academy\Infrastructure\Http\Resources\SchoolPaginatedResource;
use App\Academy\Infrastructure\Http\Resources\SchoolResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Portero HTTP: recibe peticiones, llama Handlers, devuelve JSON
// No tiene lógica de negocio, solo coordina
// Toda la lógica vive en los Handlers y Entities
final class SchoolController
{
    // Laravel inyecta los Handlers automáticamente via Service Provider
    public function __construct(
        private readonly CreateSchoolHandler $createHandler,
        private readonly UpdateSchoolHandler $updateHandler,
        private readonly DeleteSchoolHandler $deleteHandler,
        private readonly FindSchoolHandler   $findHandler,
        private readonly ListSchoolsHandler  $listHandler,
    ) {}

    // GET /schools
    // Lista Schools paginados con búsqueda y ordenamiento opcionales
    public function index(Request $request): JsonResponse
    {
        $query = new ListSchoolsQuery(
            page: (int) $request->get('page', 1),
            perPage: (int) $request->get('per_page', 15),
            search: $request->get('search'),
            orderBy: $request->get('order_by', 'name'),
            orderDir: $request->get('order_dir', 'asc'),
        );

        $result = ($this->listHandler)($query);

        return response()->json(
            new SchoolPaginatedResource($result)
        );
    }

    // POST /schools
    // Crea un School nuevo
    public function store(SchoolRequest $request): JsonResponse
    {
        try {
            // Controller genera el UUID antes de llamar al Handler
            // Así conoce el ID antes de que se persista
            $command = new CreateSchoolCommand(
                id: Str::uuid()->toString(),
                name: $request->validated('name'),
            );

            ($this->createHandler)($command);

            // Busca el School recién creado para devolverlo en la respuesta
            $school = ($this->findHandler)(new FindSchoolQuery($command->id));

            return response()->json(
                new SchoolResource($school),
                201 // HTTP 201 Created
            );
        } catch (SchoolAlreadyExistsException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    // GET /schools/{id}
    // Busca un School por ID
    public function show(string $id): JsonResponse
    {
        try {
            $school = ($this->findHandler)(new FindSchoolQuery($id));

            return response()->json(
                new SchoolResource($school)
            );
        } catch (SchoolNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }

    // PUT /schools/{id}
    // Actualiza un School existente
    public function update(SchoolRequest $request, string $id): JsonResponse
    {
        try {
            $command = new UpdateSchoolCommand(
                id: $id,
                name: $request->validated('name'),
            );

            ($this->updateHandler)($command);

            // Busca el School actualizado para devolverlo
            $school = ($this->findHandler)(new FindSchoolQuery($id));

            return response()->json(
                new SchoolResource($school)
            );
        } catch (SchoolNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        } catch (SchoolAlreadyExistsException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    // DELETE /schools/{id}
    // Elimina un School
    public function destroy(string $id): JsonResponse
    {
        try {
            ($this->deleteHandler)(new DeleteSchoolCommand($id));

            // HTTP 204 No Content: éxito sin cuerpo de respuesta
            return response()->json(null, 204);
        } catch (SchoolNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
