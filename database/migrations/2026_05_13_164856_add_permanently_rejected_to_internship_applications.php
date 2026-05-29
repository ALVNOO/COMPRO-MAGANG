<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE internship_applications DROP CONSTRAINT IF EXISTS internship_applications_status_check');

            DB::statement(
                "ALTER TABLE internship_applications ADD CONSTRAINT internship_applications_status_check CHECK (status IN ('pending', 'accepted', 'rejected', 'finished', 'postponed', 'permanently_rejected'))"
            );

            return;
        }

        if ($driver === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE internship_applications MODIFY COLUMN status ENUM('pending','accepted','rejected','finished','postponed','permanently_rejected') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::table('internship_applications')
                ->where('status', 'permanently_rejected')
                ->update(['status' => 'rejected']);

            DB::statement('ALTER TABLE internship_applications DROP CONSTRAINT IF EXISTS internship_applications_status_check');

            DB::statement(
                "ALTER TABLE internship_applications ADD CONSTRAINT internship_applications_status_check CHECK (status IN ('pending', 'accepted', 'rejected', 'finished', 'postponed'))"
            );

            return;
        }

        if ($driver === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE internship_applications MODIFY COLUMN status ENUM('pending','accepted','rejected','finished','postponed') NOT NULL DEFAULT 'pending'");
    }
};
