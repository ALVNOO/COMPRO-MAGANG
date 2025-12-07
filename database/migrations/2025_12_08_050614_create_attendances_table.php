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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['Hadir', 'Absen', 'Terlambat'])->default('Hadir');
            $table->time('check_in_time')->nullable();
            $table->string('photo_path')->nullable(); // Path foto selfie untuk check in
            $table->text('absence_reason')->nullable(); // Alasan jika absen
            $table->string('absence_proof_path')->nullable(); // Bukti jika absen (file)
            $table->timestamps();
            
            // Unique constraint: satu user hanya bisa absen sekali per hari
            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
