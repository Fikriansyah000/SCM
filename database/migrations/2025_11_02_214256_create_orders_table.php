<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('shop_id')->constrained('shops')->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->enum('status', [
                'pending',      // Menunggu konfirmasi penjual
                'processing',   // Penjual sedang mempersiapkan
                'shipped',      // Sedang dalam pengiriman
                'delivered',    // Sudah diterima pembeli
                'completed',    // Transaksi selesai
                'cancelled'     // Dibatalkan
            ])->default('pending');
            $table->decimal('total_amount', 12, 2);
            $table->text('shipping_address')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamp('confirmed_at')->nullable();    // Saat penjual confirm
            $table->timestamp('shipped_at')->nullable();      // Saat barang dikirim
            $table->timestamp('delivered_at')->nullable();    // Saat barang diterima
            $table->timestamp('completed_at')->nullable();    // Saat order selesai
            $table->timestamp('cancelled_at')->nullable();    // Saat order dibatalkan
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
