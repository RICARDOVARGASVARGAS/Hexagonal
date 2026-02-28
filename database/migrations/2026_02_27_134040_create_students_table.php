<?php

declare(strict_types=1);

use App\Academy\Domain\Enums\StudentSex;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'academy';

    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('document_number', 20)->unique();
            $table->string('name', 255);
            $table->foreignUuid('school_id')
                ->constrained('schools')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->enum('sex', StudentSex::values())->default(StudentSex::Male->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
