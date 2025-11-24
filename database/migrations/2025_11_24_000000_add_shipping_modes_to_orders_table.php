<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kolom shipping mode dan biaya detail
            $table->enum('shipping_mode', ['reguler', 'same_day', 'instant'])->default('reguler')->after('shipping_method');
            $table->decimal('shipping_cost', 12, 2)->nullable()->after('shipping_mode');
            $table->decimal('total_weight', 8, 2)->nullable()->after('shipping_cost'); // dalam kg
            
            // Estimasi dan tracking
            $table->timestamp('estimated_delivery')->nullable()->after('total_weight');
            $table->timestamp('actual_delivery')->nullable()->after('estimated_delivery');
            $table->text('tracking_url')->nullable()->after('actual_delivery');
            
            // Shipping status tracking
            $table->enum('shipping_status', [
                'pending',          // Menunggu pickup
                'picked_up',        // Sudah diambil kurir
                'in_transit',       // Dalam perjalanan
                'at_delivery_hub',  // Di hub pengiriman lokal
                'out_for_delivery', // Sedang diantar ke pembeli
                'delivered',        // Delivered
                'failed_delivery'   // Gagal kirim
            ])->default('pending')->after('tracking_url');
            
            // Info kurir untuk Same Day/Instant
            $table->string('courier_name')->nullable()->after('shipping_status');
            $table->string('courier_phone')->nullable()->after('courier_name');
            $table->string('live_tracking_url')->nullable()->after('courier_phone');
            
            // Cutoff alerts
            $table->boolean('cutoff_exceeded')->default(false)->after('live_tracking_url');
            $table->timestamp('cutoff_time')->nullable()->after('cutoff_exceeded');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_mode',
                'shipping_cost',
                'total_weight',
                'estimated_delivery',
                'actual_delivery',
                'tracking_url',
                'shipping_status',
                'courier_name',
                'courier_phone',
                'live_tracking_url',
                'cutoff_exceeded',
                'cutoff_time'
            ]);
        });
    }
};
