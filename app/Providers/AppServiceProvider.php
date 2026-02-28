<?php

namespace App\Providers;

use App\Academy\Domain\Repositories\SchoolRepository;
use App\Academy\Infrastructure\Persistence\EloquentSchoolRepository;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Agrega aquí cada nuevo schema que crees
    private array $extraSchemas = [
        'academy',
        'store',
        // 'finance',
        // 'hr',
    ];

    public function register(): void
    {
        $this->app->bind(
            SchoolRepository::class,
            EloquentSchoolRepository::class
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            Event::listen(MigrationsStarted::class, function () {
                if (app('migrator')->repositoryExists()) {
                    foreach ($this->extraSchemas as $schema) {
                        DB::statement("DROP SCHEMA IF EXISTS {$schema} CASCADE");
                    }
                }
            });
        }
    }
}
