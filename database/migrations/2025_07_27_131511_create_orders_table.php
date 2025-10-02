<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade');
            $table->foreignId('store_id')
                  ->constrained('drugstores')
                  ->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discounted_amount', 10, 2)->default(0.00);
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->enum('payment_mode', ['walk-in', 'cash on delivery']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

