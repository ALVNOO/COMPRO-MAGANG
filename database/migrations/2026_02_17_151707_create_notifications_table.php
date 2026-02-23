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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // assignment_created, assignment_graded, attendance_reminder, deadline_warning
            $table->string('title');
            $table->text('message');
            $table->string('icon')->default('info'); // success, info, warning, error
            $table->string('link')->nullable(); // URL untuk redirect saat diklik
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->json('data')->nullable(); // Data tambahan seperti assignment_id, dll
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
