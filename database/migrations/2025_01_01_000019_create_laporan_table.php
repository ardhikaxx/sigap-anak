<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255)->nullable();
            $table->enum('tipe', ['bulanan', 'triwulan', 'tahunan', 'khusus']);
            $table->date('periode_mulai')->nullable();
            $table->date('periode_selesai')->nullable();
            $table->foreignId('faskes_id')->nullable()->constrained('fasilitas_kesehatan')->onDelete('set null');
            $table->foreignId('wilayah_id')->nullable()->constrained('wilayah')->onDelete('set null');
            $table->foreignId('pembuat_id')->nullable()->constrained('users')->onDelete('set null');
            $table->json('data_laporan')->nullable();
            $table->string('file_path', 255)->nullable();
            $table->enum('status', ['draft', 'final', 'disetujui'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
