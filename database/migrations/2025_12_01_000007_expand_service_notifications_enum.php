<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $types = [
        'info',
        'promo',
        'security',
        'order',
        'new_order',
        'order_confirmed',
        'order_shipped',
        'shipping_update',
        'order_delivered',
        'order_completed',
        'order_cancelled',
        'return_requested',
        'return_approved',
        'return_rejected',
        'return_shipped',
        'return_received',
        'service_proposal',
        'service_proposal_accepted',
        'service_proposal_rejected',
        'service_paid',
        'service_work_started',
        'service_review_submitted',
        'service_revision_requested',
        'service_completed',
        'service_cancelled',
        'proposal_cancelled',
        'extension_requested',
        'extension_approved',
        'extension_rejected',
        'extension_auto_approved',
    ];

    public function up(): void
    {
        $enum = "'" . implode("','", $this->types) . "'";
        DB::statement("ALTER TABLE `notifications` MODIFY `type` ENUM($enum) NOT NULL DEFAULT 'info'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `notifications` MODIFY `type` ENUM('info','promo','security','order','return_requested','return_approved','return_rejected','return_shipped','return_received') NOT NULL DEFAULT 'info'");
    }
};
