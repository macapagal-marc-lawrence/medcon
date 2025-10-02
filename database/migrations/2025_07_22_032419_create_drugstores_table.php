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
       Schema::create('drugstores', function (Blueprint $table) {
            $table->id(); // own primary key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('storename');
            $table->string('storeaddress');
            $table->string('licenseno')->unique();
            $table->string('operatingdays');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drugstores');
    }
};
