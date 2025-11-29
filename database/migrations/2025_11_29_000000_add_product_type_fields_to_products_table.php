<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('product_type', ['food', 'service'])->default('food')->after('category');
            $table->json('food_profile')->nullable()->after('product_type');
            $table->json('service_profile')->nullable()->after('food_profile');
            $table->boolean('requires_booking')->default(false)->after('service_profile');
            $table->json('booking_settings')->nullable()->after('requires_booking');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'product_type',
                'food_profile',
                'service_profile',
                'requires_booking',
                'booking_settings',
            ]);
        });
    }
};
