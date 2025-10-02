<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dateTime('scheduled_pickup_date')->nullable()->after('status');
            $table->dateTime('pickup_deadline')->nullable()->after('scheduled_pickup_date');
            $table->dateTime('picked_up_at')->nullable()->after('pickup_deadline');
            // Adding a new status for voided reservations
            // Existing status values should include: 'pending', 'processing', 'completed', 'cancelled', 'voided'
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['scheduled_pickup_date', 'pickup_deadline', 'picked_up_at']);
        });
    }
};
