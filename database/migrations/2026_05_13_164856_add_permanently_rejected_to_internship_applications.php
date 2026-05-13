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
        // SQLite does not support ALTER COLUMN for enum; use a raw DB statement for MySQL/MariaDB.
        // For SQLite (tests) this is a no-op since SQLite stores enums as TEXT.
        if (config('database.default') !== 'sqlite') {
            \DB::statement("ALTER TABLE internship_applications MODIFY COLUMN status ENUM('pending','accepted','rejected','finished','postponed','permanently_rejected') NOT NULL DEFAULT 'pending'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') !== 'sqlite') {
            \DB::statement("ALTER TABLE internship_applications MODIFY COLUMN status ENUM('pending','accepted','rejected','finished','postponed') NOT NULL DEFAULT 'pending'");
        }
    }
};
