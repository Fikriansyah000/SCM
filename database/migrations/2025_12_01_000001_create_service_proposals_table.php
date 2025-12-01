<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_item_id')->nullable()->constrained()->nullOnDelete();
            
            // Proposal details
            $table->text('description'); // Buyer's work description/requirements
            $table->date('proposed_deadline'); // Buyer's requested deadline
            $table->decimal('proposed_price', 12, 2); // Buyer's offered price
            
            // Negotiation
            $table->decimal('agreed_price', 12, 2)->nullable(); // Final agreed price
            $table->date('agreed_deadline')->nullable(); // Final agreed deadline
            $table->text('seller_notes')->nullable(); // Seller's counter/notes
            
            // Status tracking
            $table->enum('status', [
                'pending',      // Waiting for seller response
                'negotiating',  // Seller counter-offered
                'accepted',     // Seller accepted
                'rejected',     // Seller rejected
                'in_progress',  // Work started
                'review',       // Submitted for buyer review
                'revision',     // Buyer requested changes
                'completed',    // Buyer approved final result
                'cancelled'     // Cancelled
            ])->default('pending');
            
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            $table->timestamps();
            
            $table->index(['buyer_id', 'status']);
            $table->index(['seller_id', 'status']);
            $table->index(['product_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_proposals');
    }
};
