<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')
                  ->constrained('drugstores')
                  ->onDelete('cascade');
            $table->string('medicine_name');
            $table->string('generic_name');
            $table->text('description')->nullable();
            $table->decimal('medicine_price', 10, 2);
            $table->unsignedInteger('quantity');
            $table->date('manufactured_date');
            $table->date('expiration_date');
            $table->string('medicine_img')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};

