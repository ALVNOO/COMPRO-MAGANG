<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add "revision" status and migrate admin revision records from legacy "rejected".
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE internship_applications DROP CONSTRAINT IF EXISTS internship_applications_status_check');
        } else {
            DB::statement("ALTER TABLE internship_applications MODIFY COLUMN status ENUM('pending','accepted','rejected','revision','finished','postponed','permanently_rejected') NOT NULL DEFAULT 'pending'");
        }

        // Legacy: admin "Revisi" used status "rejected" before "revision" existed.
        DB::table('internship_applications')
            ->where('status', 'rejected')
            ->update(['status' => 'revision']);

        if ($driver === 'pgsql') {
            DB::statement(
                "ALTER TABLE internship_applications ADD CONSTRAINT internship_applications_status_check CHECK (status IN ('pending', 'accepted', 'rejected', 'revision', 'finished', 'postponed', 'permanently_rejected'))"
            );
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE internship_applications DROP CONSTRAINT IF EXISTS internship_applications_status_check');
        }

        DB::table('internship_applications')
            ->where('status', 'revision')
            ->update(['status' => 'rejected']);

        if ($driver === 'pgsql') {
            DB::statement(
                "ALTER TABLE internship_applications ADD CONSTRAINT internship_applications_status_check CHECK (status IN ('pending', 'accepted', 'rejected', 'finished', 'postponed', 'permanently_rejected'))"
            );

            return;
        }

        DB::statement("ALTER TABLE internship_applications MODIFY COLUMN status ENUM('pending','accepted','rejected','finished','postponed','permanently_rejected') NOT NULL DEFAULT 'pending'");
    }
};
