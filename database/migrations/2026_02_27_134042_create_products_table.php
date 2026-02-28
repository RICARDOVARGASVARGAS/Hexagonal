<?php

declare(strict_types=1);

use App\Store\Domain\Enums\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'store';

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255)->unique();
            $table->decimal('price', 10, 2);
            $table->enum('status', ProductStatus::values())->default(ProductStatus::Active->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('store')->dropIfExists('products');
    }
};
