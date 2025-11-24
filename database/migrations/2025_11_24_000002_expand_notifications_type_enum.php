<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // Expand the enum to include application-specific notification types
        $types = [
            'info', 'promo', 'security', 'order',
            'new_order', 'order_confirmed', 'order_shipped', 'order_delivered', 'order_completed', 'order_cancelled',
            'shipping_update',
            'return_requested', 'return_shipped', 'return_approved', 'return_rejected', 'return_received'
        ];

        $list = implode("','", $types);

        DB::statement("ALTER TABLE `notifications` MODIFY `type` ENUM('{$list}') NOT NULL DEFAULT 'info'");
    }

    public function down(): void
    {
        // Revert back to the original smaller enum
        DB::statement("ALTER TABLE `notifications` MODIFY `type` ENUM('info','promo','security','order') NOT NULL DEFAULT 'info'");
    }
};
