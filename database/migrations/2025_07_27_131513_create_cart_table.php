<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')
                ->constrained('drugstores')
                ->onDelete('cascade');
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onDelete('cascade');
            $table->foreignId('medicine_id')
                ->constrained('medicines')
                ->onDelete('cascade');
            $table->unsignedBigInteger('order_id')->nullable(); // Fix: define column first
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->nullOnDelete(); // Laravel 8+ helper for onDelete('set null')
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
