<?php

declare(strict_types=1);

namespace App\Academy\Infrastructure\Http\Resources;

use App\Academy\Domain\Entities\School;
use App\Shared\Domain\Pagination\PaginationResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Para listado paginado: list
class SchoolPaginatedResource extends JsonResource
{
    public function __construct(
        private readonly PaginationResult $result
    ) {}

    public function toArray(Request $request): array
    {
        return [
            'data' => array_map(
                fn(School $school) => (new SchoolResource($school))->toArray($request),
                $this->result->data
            ),
            'meta' => [
                'total'        => $this->result->total,
                'per_page'     => $this->result->perPage,
                'current_page' => $this->result->currentPage,
                'last_page'    => $this->result->lastPage,
                'has_more'     => $this->result->hasMorePages(),
            ],
        ];
    }
}
