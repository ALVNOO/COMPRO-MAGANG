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
        if (Schema::hasTable('mentor_transfer_histories')) {
            return;
        }

        Schema::create('mentor_transfer_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_application_id')
                ->constrained('internship_applications')
                ->cascadeOnDelete();
            $table->foreignId('old_division_mentor_id')
                ->nullable()
                ->constrained('division_mentors')
                ->nullOnDelete();
            $table->foreignId('new_division_mentor_id')
                ->constrained('division_mentors')
                ->cascadeOnDelete();
            $table->foreignId('changed_by_admin_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_transfer_histories');
    }
};
