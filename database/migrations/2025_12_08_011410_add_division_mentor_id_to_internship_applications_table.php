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
            $table->foreignId('division_mentor_id')->nullable()->after('divisi_id')->constrained('division_mentors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropForeign(['division_mentor_id']);
            $table->dropColumn('division_mentor_id');
        });
    }
};
