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
        Schema::table('field_of_interests', function (Blueprint $table) {
            $table->dropColumn(['division_count', 'position_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('field_of_interests', function (Blueprint $table) {
            $table->integer('division_count')->default(0);
            $table->integer('position_count')->default(0);
        });
    }
};
