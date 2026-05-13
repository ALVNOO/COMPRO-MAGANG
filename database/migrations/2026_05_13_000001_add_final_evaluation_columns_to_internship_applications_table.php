<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->string('final_evaluation_participant_path')->nullable()->after('integrity_pact_path');
            $table->timestamp('final_evaluation_participant_uploaded_at')->nullable()->after('final_evaluation_participant_path');
            $table->string('final_evaluation_admin_path')->nullable()->after('final_evaluation_participant_uploaded_at');
            $table->timestamp('final_evaluation_admin_uploaded_at')->nullable()->after('final_evaluation_admin_path');
        });
    }

    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn([
                'final_evaluation_participant_path',
                'final_evaluation_participant_uploaded_at',
                'final_evaluation_admin_path',
                'final_evaluation_admin_uploaded_at',
            ]);
        });
    }
};
