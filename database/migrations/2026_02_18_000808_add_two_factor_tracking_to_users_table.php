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
        Schema::table("users", function (Blueprint $table) {
            // Add columns only if they don't exist
            if (!Schema::hasColumn("users", "two_factor_code_generated_at")) {
                $table->timestamp("two_factor_code_generated_at")->nullable();
            }
            if (!Schema::hasColumn("users", "two_factor_last_used_at")) {
                $table->timestamp("two_factor_last_used_at")->nullable();
            }
            if (!Schema::hasColumn("users", "two_factor_attempts")) {
                $table->unsignedInteger("two_factor_attempts")->default(0);
            }
            if (!Schema::hasColumn("users", "two_factor_attempts_reset_at")) {
                $table->timestamp("two_factor_attempts_reset_at")->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("users", function (Blueprint $table) {
            // Drop columns only if they exist
            $columnsToDrop = [];

            if (Schema::hasColumn("users", "two_factor_code_generated_at")) {
                $columnsToDrop[] = "two_factor_code_generated_at";
            }
            if (Schema::hasColumn("users", "two_factor_last_used_at")) {
                $columnsToDrop[] = "two_factor_last_used_at";
            }
            if (Schema::hasColumn("users", "two_factor_attempts")) {
                $columnsToDrop[] = "two_factor_attempts";
            }
            if (Schema::hasColumn("users", "two_factor_attempts_reset_at")) {
                $columnsToDrop[] = "two_factor_attempts_reset_at";
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
