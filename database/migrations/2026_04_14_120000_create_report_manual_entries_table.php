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
        Schema::create('report_manual_entries', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('universitas');
            $table->string('jurusan');
            $table->string('nim');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir')->nullable();
            $table->string('divisi');
            $table->string('judul_proyek')->nullable();
            $table->decimal('nilai', 5, 1)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_manual_entries');
    }
};
