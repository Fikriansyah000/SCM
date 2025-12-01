<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_proposals', function (Blueprint $table) {
            if (!Schema::hasColumn('service_proposals', 'notes')) {
                $table->text('notes')->nullable()->after('seller_notes');
            }
            if (!Schema::hasColumn('service_proposals', 'responded_at')) {
                $table->timestamp('responded_at')->nullable()->after('accepted_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('service_proposals', function (Blueprint $table) {
            $table->dropColumn(['notes', 'responded_at']);
        });
    }
};
