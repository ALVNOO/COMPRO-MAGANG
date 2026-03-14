<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Memperlebar kolom string di users agar data dari SQLite (username/name/email panjang) bisa masuk ke PostgreSQL.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE users ALTER COLUMN username TYPE VARCHAR(255)');
        DB::statement('ALTER TABLE users ALTER COLUMN name TYPE VARCHAR(255)');
        DB::statement('ALTER TABLE users ALTER COLUMN email TYPE VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement('ALTER TABLE users ALTER COLUMN username TYPE VARCHAR(100)');
        DB::statement('ALTER TABLE users ALTER COLUMN name TYPE VARCHAR(100)');
        DB::statement('ALTER TABLE users ALTER COLUMN email TYPE VARCHAR(100)');
    }
};
