<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix the specific record with incorrect format
        DB::table('attendances')
            ->where('id', 28)
            ->update([
                'punch_in_time' => '08:32:00 AM',
                'punch_out_time' => '05:30:00 PM'
            ]);
            
        // Also fix any other records that might have missing AM/PM
        DB::table('attendances')
            ->where('punch_in_time', 'NOT LIKE', '%AM')
            ->where('punch_in_time', 'NOT LIKE', '%PM')
            ->whereNotNull('punch_in_time')
            ->update([
                'punch_in_time' => DB::raw("CONCAT(punch_in_time, ' AM')")
            ]);
            
        DB::table('attendances')
            ->where('punch_out_time', 'NOT LIKE', '%AM')
            ->where('punch_out_time', 'NOT LIKE', '%PM')
            ->whereNotNull('punch_out_time')
            ->update([
                'punch_out_time' => DB::raw("CONCAT(punch_out_time, ' PM')")
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse
    }
};