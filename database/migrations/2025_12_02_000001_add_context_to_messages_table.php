<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Context for reply product/proposal feature
            $table->enum('context_type', ['product', 'proposal'])->nullable()->after('message');
            $table->unsignedBigInteger('context_id')->nullable()->after('context_type');
            
            // Index for quick lookup
            $table->index(['context_type', 'context_id']);
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['context_type', 'context_id']);
            $table->dropColumn(['context_type', 'context_id']);
        });
    }
};
