<?php

declare(strict_types=1);

namespace App\Providers;

use App\Academy\Domain\Repositories\SchoolRepository;
use App\Academy\Infrastructure\Persistence\EloquentSchoolRepository;
use Illuminate\Support\ServiceProvider;

// Conecta las interfaces del Domain con las implementaciones de Infrastructure
// Sin esto Laravel no sabe qué clase usar cuando alguien pide SchoolRepository
class AcademyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // "cuando alguien pida SchoolRepository,
        //  dale EloquentSchoolRepository"
        $this->app->bind(
            SchoolRepository::class,
            EloquentSchoolRepository::class
        );
    }
}
