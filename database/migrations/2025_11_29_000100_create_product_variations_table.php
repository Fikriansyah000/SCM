<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('variation_type', ['option', 'addon', 'bundle'])->default('option');
            $table->decimal('price_adjustment', 10, 2)->default(0);
            $table->integer('stock')->nullable();
            $table->boolean('is_default')->default(false);
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'name', 'variation_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variations');
    }
};
