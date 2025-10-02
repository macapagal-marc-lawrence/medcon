<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, modify the enum to include all possible statuses
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'approved', 'rejected', 'completed', 'voided') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'approved') DEFAULT 'pending'");
    }
};
