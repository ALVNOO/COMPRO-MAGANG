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
            if (!Schema::hasColumn('internship_applications', 'field_of_interest_id')) {
                $table->unsignedBigInteger('field_of_interest_id')->nullable()->after('divisi_id');
                $table->foreign('field_of_interest_id')->references('id')->on('field_of_interests')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            if (Schema::hasColumn('internship_applications', 'field_of_interest_id')) {
                $table->dropForeign(['field_of_interest_id']);
                $table->dropColumn('field_of_interest_id');
            }
        });
    }
};
