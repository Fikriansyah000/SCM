<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_extensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_proposal_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade'); // Seller who requested
            
            // Extension details
            $table->integer('extension_days'); // Number of days to extend
            $table->text('reason'); // Required reason for extension
            $table->date('original_deadline'); // Deadline before extension
            $table->date('new_deadline'); // Proposed new deadline
            
            // Status tracking
            $table->enum('status', [
                'pending',       // Waiting for buyer response
                'approved',      // Buyer approved
                'rejected',      // Buyer rejected
                'auto_approved'  // System auto-approved after 24h
            ])->default('pending');
            
            // Response
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('response_message')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('auto_approve_at')->nullable(); // When auto-approval should trigger
            
            $table->timestamps();
            
            $table->index(['order_id', 'status']);
            $table->index(['status', 'auto_approve_at']); // For auto-approval job
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_extensions');
    }
};
