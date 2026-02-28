<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Academy\Infrastructure\Persistence\EloquentSchoolModel;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        // 10 colegios activos
        EloquentSchoolModel::factory(10)->create();

        // 3 colegios inactivos
        EloquentSchoolModel::factory(3)->inactive()->create();
    }
}
