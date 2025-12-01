<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_item_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_proposal_id')->nullable()->constrained()->nullOnDelete();
            
            // Actor information
            $table->string('actor_type'); // 'buyer', 'seller', 'system'
            $table->unsignedBigInteger('actor_id')->nullable(); // user_id or null for system
            
            // Event details
            $table->string('event_type'); // proposal_created, accepted, in_progress, review_submitted, revision_requested, extension_requested, extension_approved, auto_approved, completed, cancelled
            $table->string('title'); // Human-readable title
            $table->text('message')->nullable(); // Detailed message
            $table->json('metadata')->nullable(); // Additional data (old_deadline, new_deadline, price changes, etc.)
            
            // Visibility
            $table->boolean('visible_to_buyer')->default(true);
            $table->boolean('visible_to_seller')->default(true);
            
            $table->timestamp('created_at')->useCurrent();
            
            $table->index(['order_id', 'created_at']);
            $table->index(['service_proposal_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_events');
    }
};
