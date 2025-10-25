<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('prescription_submissions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('prescription_id')->constrained()->onDelete('cascade');
        $table->foreignId('customer_id')->constrained()->onDelete('cascade');
        $table->foreignId('drugstore_id')->constrained('drugstores')->onDelete('cascade');
        $table->string('file_path'); // uploaded image/pdf of prescription
        $table->enum('status', ['pending', 'sent', 'reviewed', 'approved', 'rejected'])->default('pending');
        $table->timestamp('sent_at')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_submissions');
    }
};
