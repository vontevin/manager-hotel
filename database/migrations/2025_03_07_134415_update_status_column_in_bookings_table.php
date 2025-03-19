<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColumnInBookingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the 'status' enum column
        DB::statement("ALTER TABLE bookings CHANGE status status ENUM('pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled', 'no_show') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the changes to the 'status' enum column
        DB::statement("ALTER TABLE bookings CHANGE status status ENUM('pending', 'confirmed', 'canceled') DEFAULT 'pending'");
    }
}

