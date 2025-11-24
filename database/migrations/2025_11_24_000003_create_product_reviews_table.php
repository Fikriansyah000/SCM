<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned();
            $table->string('title')->nullable();
            $table->text('review')->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'user_id', 'order_id'], 'product_user_order_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
