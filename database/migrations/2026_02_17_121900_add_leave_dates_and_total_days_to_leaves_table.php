<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            if (!Schema::hasColumn('leaves', 'leave_dates')) {
                $table->text('leave_dates');
            }

            if (!Schema::hasColumn('leaves', 'total_days')) {
                $table->decimal('total_days', 5, 1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            if (Schema::hasColumn('leaves', 'leave_dates')) {
                $table->dropColumn('leave_dates');
            }

            if (Schema::hasColumn('leaves', 'total_days')) {
                $table->dropColumn('total_days');
            }
        });
    }
};
