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
        // internship_applications — most-queried table; WHERE status, WHERE (user_id, status),
        // WHERE (division_mentor_id, status), WHERE (division_admin_id, status)
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->index('status', 'idx_ia_status');
            $table->index(['user_id', 'status'], 'idx_ia_user_status');
            $table->index(['division_mentor_id', 'status'], 'idx_ia_mentor_status');
            $table->index(['division_admin_id', 'status'], 'idx_ia_division_status');
        });

        // assignments — WHERE user_id (N+1 fix queries), WHERE (is_revision, grade)
        Schema::table('assignments', function (Blueprint $table) {
            $table->index('user_id', 'idx_assignments_user');
            $table->index(['user_id', 'grade'], 'idx_assignments_user_grade');
            $table->index('is_revision', 'idx_assignments_revision');
        });

        // notifications — WHERE user_id (already has composite, but adding single for fast counts)
        Schema::table('notifications', function (Blueprint $table) {
            $table->index('created_at', 'idx_notifications_created');
        });

        // logbooks — date range queries across all users (for admin view)
        Schema::table('logbooks', function (Blueprint $table) {
            $table->index('date', 'idx_logbooks_date');
        });

        // attendances — date range queries across all users (for admin view)
        Schema::table('attendances', function (Blueprint $table) {
            $table->index('date', 'idx_attendances_date');
        });
    }

    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropIndex('idx_ia_status');
            $table->dropIndex('idx_ia_user_status');
            $table->dropIndex('idx_ia_mentor_status');
            $table->dropIndex('idx_ia_division_status');
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropIndex('idx_assignments_user');
            $table->dropIndex('idx_assignments_user_grade');
            $table->dropIndex('idx_assignments_revision');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex('idx_notifications_created');
        });

        Schema::table('logbooks', function (Blueprint $table) {
            $table->dropIndex('idx_logbooks_date');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex('idx_attendances_date');
        });
    }
};
