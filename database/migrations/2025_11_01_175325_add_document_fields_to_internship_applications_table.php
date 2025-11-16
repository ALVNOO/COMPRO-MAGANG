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
            if (!Schema::hasColumn('internship_applications', 'ktm_path')) {
                $table->string('ktm_path')->nullable()->after('cover_letter_path');
            }
            if (!Schema::hasColumn('internship_applications', 'surat_permohonan_path')) {
                $table->string('surat_permohonan_path')->nullable();
            }
            if (!Schema::hasColumn('internship_applications', 'cv_path')) {
                $table->string('cv_path')->nullable();
            }
            if (!Schema::hasColumn('internship_applications', 'good_behavior_path')) {
                $table->string('good_behavior_path')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn(['ktm_path', 'surat_permohonan_path', 'cv_path', 'good_behavior_path']);
        });
    }
};
