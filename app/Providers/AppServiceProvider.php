<?php

namespace App\Providers;

use App\Academy\Domain\Repositories\SchoolRepository;
use App\Academy\Infrastructure\Persistence\EloquentSchoolRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Academy
        $this->app->bind(
            SchoolRepository::class,
            EloquentSchoolRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Hook que se ejecuta ANTES de migrate:fresh
    if ($this->app->runningInConsole()) {
        $this->app->booted(function () {
            \Illuminate\Support\Facades\Event::listen(
                \Illuminate\Database\Events\MigrationsStarted::class,
                function () {
                    if (app('migrator')->repositoryExists()) {
                        \Illuminate\Support\Facades\DB::statement('DROP SCHEMA IF EXISTS academy CASCADE');
                        \Illuminate\Support\Facades\DB::statement('DROP SCHEMA IF EXISTS store CASCADE');
                    }
                }
            );
        });
    }
    }
}
