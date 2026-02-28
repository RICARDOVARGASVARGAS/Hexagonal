<?php

declare(strict_types=1);

use App\Academy\Domain\Enums\SchoolStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'academy';

    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255)->unique();
            $table->enum('status', SchoolStatus::values())->default(SchoolStatus::Active->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Debe usar la misma conexión que el up()
        Schema::connection('academy')->dropIfExists('schools');
    }
};
