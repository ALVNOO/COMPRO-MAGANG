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
            if (!Schema::hasColumn('internship_applications', 'assessment_report_path')) {
                $table->string('assessment_report_path')->nullable()->after('end_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            if (Schema::hasColumn('internship_applications', 'assessment_report_path')) {
                $table->dropColumn('assessment_report_path');
            }
        });
    }
};
