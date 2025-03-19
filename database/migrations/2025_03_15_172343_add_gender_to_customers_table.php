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
        Schema::table('customers', function (Blueprint $table) {
            // Add the gender column
            $table->string('gender')->nullable(); // Use string for flexibility
            // OR use enum for specific values
            // $table->enum('gender', ['male', 'female', 'other'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Remove the gender column if rolling back
            $table->dropColumn('gender');
        });
    }
};
