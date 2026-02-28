<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'store';

    public function up(): void
    {
        Schema::create('client_product', function (Blueprint $table) {
            $table->foreignUuid('client_id')
                ->constrained('clients')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignUuid('product_id')
                ->constrained('products')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);

            // PK compuesta: un cliente no puede tener el mismo producto dos veces
            $table->primary(['client_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_product');
    }
};
