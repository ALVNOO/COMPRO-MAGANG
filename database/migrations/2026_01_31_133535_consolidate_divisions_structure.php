<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Migration to consolidate division structure.
 *
 * This migration:
 * 1. Adds division_id column to internship_applications (alias for division_admin_id)
 * 2. Prepares for removal of old Divisi/Direktorat/SubDirektorat structure
 *
 * Note: Old tables (divisis, sub_direktorats, direktorats) are NOT dropped in this migration
 * to allow for gradual migration. They should be dropped in a future migration after
 * confirming all data has been migrated.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes for better query performance on divisions table
        if (!$this->indexExists('divisions', 'divisions_is_active_index')) {
            Schema::table('divisions', function (Blueprint $table) {
                $table->index('is_active');
            });
        }

        if (!$this->indexExists('divisions', 'divisions_sort_order_index')) {
            Schema::table('divisions', function (Blueprint $table) {
                $table->index('sort_order');
            });
        }

        // Add index on division_admin_id in internship_applications for better performance
        if (!$this->indexExists('internship_applications', 'internship_applications_division_admin_id_index')) {
            Schema::table('internship_applications', function (Blueprint $table) {
                $table->index('division_admin_id');
            });
        }

        // Add index on division_mentor_id in internship_applications
        if (!$this->indexExists('internship_applications', 'internship_applications_division_mentor_id_index')) {
            Schema::table('internship_applications', function (Blueprint $table) {
                $table->index('division_mentor_id');
            });
        }

        // Add created_by and updated_by columns to divisions for audit trail (optional)
        if (!Schema::hasColumn('divisions', 'created_by')) {
            Schema::table('divisions', function (Blueprint $table) {
                $table->unsignedBigInteger('created_by')->nullable()->after('sort_order');
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove audit columns
        if (Schema::hasColumn('divisions', 'created_by')) {
            Schema::table('divisions', function (Blueprint $table) {
                $table->dropColumn(['created_by', 'updated_by']);
            });
        }

        // Remove indexes (only if they exist)
        if ($this->indexExists('divisions', 'divisions_is_active_index')) {
            Schema::table('divisions', function (Blueprint $table) {
                $table->dropIndex('divisions_is_active_index');
            });
        }

        if ($this->indexExists('divisions', 'divisions_sort_order_index')) {
            Schema::table('divisions', function (Blueprint $table) {
                $table->dropIndex('divisions_sort_order_index');
            });
        }

        if ($this->indexExists('internship_applications', 'internship_applications_division_admin_id_index')) {
            Schema::table('internship_applications', function (Blueprint $table) {
                $table->dropIndex('internship_applications_division_admin_id_index');
            });
        }

        if ($this->indexExists('internship_applications', 'internship_applications_division_mentor_id_index')) {
            Schema::table('internship_applications', function (Blueprint $table) {
                $table->dropIndex('internship_applications_division_mentor_id_index');
            });
        }
    }

    /**
     * Check if an index exists on a table.
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $connection = Schema::getConnection();
        $driver = $connection->getDriverName();

        if ($driver === 'mysql') {
            $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
            return count($indexes) > 0;
        } elseif ($driver === 'sqlite') {
            $indexes = DB::select("PRAGMA index_list({$table})");
            foreach ($indexes as $index) {
                if ($index->name === $indexName) {
                    return true;
                }
            }
            return false;
        } elseif ($driver === 'pgsql') {
            $indexes = DB::select("SELECT indexname FROM pg_indexes WHERE tablename = ? AND indexname = ?", [$table, $indexName]);
            return count($indexes) > 0;
        }

        return false;
    }
};
