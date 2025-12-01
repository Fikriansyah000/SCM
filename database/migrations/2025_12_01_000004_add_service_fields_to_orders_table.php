<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Service-specific fields
            $table->boolean('is_service_order')->default(false)->after('status');
            $table->date('service_due_at')->nullable()->after('is_service_order');
            $table->enum('service_status', [
                'pending',      // Proposal pending
                'accepted',     // Seller accepted
                'in_progress',  // Work in progress
                'review',       // Submitted for review
                'revision',     // Revision requested
                'completed',    // Buyer approved
                'cancelled'     // Cancelled
            ])->nullable()->after('service_due_at');
        });
        
        // Update orders.status enum to include service states
        $statuses = [
            'pending',
            'processing',
            'shipped',
            'delivered',
            'completed',
            'cancelled',
            // Service-specific
            'service_pending',
            'service_accepted',
            'service_in_progress',
            'service_review',
            'service_revision',
            'service_completed'
        ];
        
        $list = implode("','", $statuses);
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('{$list}') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['is_service_order', 'service_due_at', 'service_status']);
        });
        
        // Revert status enum
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'completed', 'cancelled'];
        $list = implode("','", $statuses);
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('{$list}') NOT NULL DEFAULT 'pending'");
    }
};
