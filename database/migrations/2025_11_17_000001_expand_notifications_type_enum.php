<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // Add return-related types to notifications.type enum
        DB::statement("ALTER TABLE `notifications` MODIFY `type` ENUM('info','promo','security','order','return_requested','return_approved','return_rejected','return_shipped','return_received') NOT NULL DEFAULT 'info'");
    }

    public function down(): void
    {
        // Revert back to original allowed values
        DB::statement("ALTER TABLE `notifications` MODIFY `type` ENUM('info','promo','security','order') NOT NULL DEFAULT 'info'");
    }
};
