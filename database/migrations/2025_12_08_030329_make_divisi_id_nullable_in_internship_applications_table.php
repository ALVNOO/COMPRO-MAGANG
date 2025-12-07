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
        Schema::table('internship_applications', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['divisi_id']);
            // Make divisi_id nullable
            $table->unsignedBigInteger('divisi_id')->nullable()->change();
            // Re-add foreign key constraint with nullable
            $table->foreign('divisi_id')->references('id')->on('divisis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['divisi_id']);
            // Make divisi_id not nullable
            $table->unsignedBigInteger('divisi_id')->nullable(false)->change();
            // Re-add foreign key constraint
            $table->foreign('divisi_id')->references('id')->on('divisis')->onDelete('cascade');
        });
    }
};
