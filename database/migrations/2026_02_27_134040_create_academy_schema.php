<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Esta migration usa la conexión default (pgsql → schema public)
    // porque los schemas se crean a nivel de base de datos, no dentro de un schema
    public function up(): void
    {
        DB::statement('CREATE SCHEMA IF NOT EXISTS academy');
    }

    public function down(): void
    {
        // CASCADE elimina todo lo que hay dentro del schema automáticamente
        DB::statement('DROP SCHEMA IF EXISTS academy CASCADE');
    }
};
