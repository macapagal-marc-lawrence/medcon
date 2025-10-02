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
        Schema::table('drugstores', function (Blueprint $table) {
            $table->string('bir_number')->nullable()->after('licenseno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drugstores', function (Blueprint $table) {
            $table->dropColumn('bir_number');
        });
    }
};
