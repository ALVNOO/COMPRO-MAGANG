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
            $table->string('trusted_device_token')->nullable()->after('remember_token');
            $table->timestamp('trusted_device_expires_at')->nullable()->after('trusted_device_token');
            $table->string('device_fingerprint')->nullable()->after('trusted_device_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['trusted_device_token', 'trusted_device_expires_at', 'device_fingerprint']);
        });
    }
};
