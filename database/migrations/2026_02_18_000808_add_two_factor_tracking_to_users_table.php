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
        Schema::table('users', function (Blueprint $table) {
            // Additional 2FA tracking & rate limiting fields
            $table->timestamp('two_factor_code_generated_at')->nullable();
            $table->timestamp('two_factor_last_used_at')->nullable();
            $table->unsignedInteger('two_factor_attempts')->default(0);
            $table->timestamp('two_factor_attempts_reset_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'two_factor_code_generated_at',
                'two_factor_last_used_at',
                'two_factor_attempts',
                'two_factor_attempts_reset_at',
            ]);
        });
    }
};
