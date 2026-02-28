<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Academy\Infrastructure\Persistence\EloquentSchoolModel;
use App\Academy\Domain\Enums\SchoolStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SchoolFactory extends Factory
{
    protected $model = EloquentSchoolModel::class;

    public function definition(): array
    {
        return [
            'id'     => Str::uuid()->toString(),
            'name'   => 'Colegio ' . $this->faker->unique()->company(),
            'status' => SchoolStatus::Active->value,
        ];
    }

    // Estado para crear Schools inactivos
    public function inactive(): self
    {
        return $this->state(['status' => SchoolStatus::Inactive->value]);
    }
}
