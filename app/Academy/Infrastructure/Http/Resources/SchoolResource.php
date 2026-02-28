<?php

declare(strict_types=1);

namespace App\Academy\Infrastructure\Http\Resources;

use App\Academy\Domain\Entities\School;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    // JsonResource espera un modelo Eloquent normalmente
    // Nosotros le pasamos una Entity, por eso redefinimos el constructor
    public function __construct(
        private readonly School $school
    ) {
        // No llamamos parent::__construct() porque no usamos Eloquent aquí
    }

    // Transforma la Entity en array para JSON
    // Recibe: Request (Laravel lo pasa automáticamente)
    // Retorna: array que se convierte en JSON
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->school->id,
            'name'       => $this->school->name(),
            'status'     => $this->school->status()->value,  // 'active'
            'is_active'  => $this->school->isActive(),       // true o false
            'created_at' => $this->school->createdAt->toDateTimeString(),
            'updated_at' => $this->school->updatedAt()->toDateTimeString(),
        ];
    }
}