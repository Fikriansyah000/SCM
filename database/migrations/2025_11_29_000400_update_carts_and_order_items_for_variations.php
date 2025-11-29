<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Ensure standalone indexes exist for FKs before dropping composite unique
            $table->index('user_id', 'carts_user_id_index');
            $table->index('product_id', 'carts_product_id_index');

            // Drop old unique (user_id, product_id) now that separate indexes exist
            $table->dropUnique('carts_user_id_product_id_unique');

            // Add variation + customizations
            $table->foreignId('product_variation_id')->nullable()->after('product_id')->constrained()->nullOnDelete();
            $table->json('customizations')->nullable()->after('quantity');

            // New uniqueness: allow multiple entries only when variation differs
            $table->unique(['user_id', 'product_id', 'product_variation_id'], 'carts_unique_product_variation');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('product_variation_id')->nullable()->after('product_id')->constrained()->nullOnDelete();
            $table->json('option_snapshot')->nullable()->after('price');
            $table->dateTime('service_start_at')->nullable()->after('option_snapshot');
            $table->dateTime('service_end_at')->nullable()->after('service_start_at');
            $table->json('service_details')->nullable()->after('service_end_at');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropUnique('carts_unique_product_variation');
            $table->dropConstrainedForeignId('product_variation_id');
            $table->dropColumn('customizations');
            // Restore original unique
            $table->unique(['user_id', 'product_id'], 'carts_user_id_product_id_unique');
            // Optional: drop helper indexes if they exist
            $table->dropIndex('carts_user_id_index');
            $table->dropIndex('carts_product_id_index');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_variation_id');
            $table->dropColumn([
                'option_snapshot',
                'service_start_at',
                'service_end_at',
                'service_details',
            ]);
        });
    }
};
