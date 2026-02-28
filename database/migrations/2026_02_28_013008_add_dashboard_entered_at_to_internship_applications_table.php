<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->timestamp('dashboard_entered_at')->nullable()->after('acceptance_letter_downloaded_at');
        });

        // Backfill: set dashboard_entered_at for existing accepted/finished applications
        DB::table('internship_applications')
            ->whereIn('status', ['accepted', 'finished'])
            ->whereNull('dashboard_entered_at')
            ->update(['dashboard_entered_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn('dashboard_entered_at');
        });
    }
};
