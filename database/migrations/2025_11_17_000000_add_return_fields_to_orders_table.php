<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('return_status')->nullable()->after('notes'); // requested, approved, shipped, received, rejected
            $table->text('return_reason')->nullable()->after('return_status');
            $table->timestamp('return_requested_at')->nullable()->after('return_reason');
            $table->string('return_tracking_number')->nullable()->after('return_requested_at');
            $table->timestamp('return_shipped_at')->nullable()->after('return_tracking_number');
            $table->timestamp('return_received_at')->nullable()->after('return_shipped_at');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'return_status', 'return_reason', 'return_requested_at',
                'return_tracking_number', 'return_shipped_at', 'return_received_at'
            ]);
        });
    }
};
