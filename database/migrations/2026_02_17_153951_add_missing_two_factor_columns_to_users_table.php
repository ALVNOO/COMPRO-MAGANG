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
            $table->timestamp('two_factor_code_generated_at')->nullable()->after('two_factor_verified_at');
            $table->timestamp('two_factor_last_used_at')->nullable()->after('two_factor_code_generated_at');
            $table->integer('two_factor_attempts')->default(0)->after('two_factor_last_used_at');
            $table->timestamp('two_factor_attempts_reset_at')->nullable()->after('two_factor_attempts');
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
                'two_factor_attempts_reset_at'
            ]);
        });
    }
};
