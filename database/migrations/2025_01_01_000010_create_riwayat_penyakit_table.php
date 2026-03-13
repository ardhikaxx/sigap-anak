<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_penyakit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak')->onDelete('cascade');
            $table->string('nama_penyakit', 150);
            $table->string('kode_icd', 20)->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->text('gejala')->nullable();
            $table->text('pengobatan')->nullable();
            $table->unsignedBigInteger('nakes_id')->nullable();
            $table->foreign('nakes_id')->references('id')->on('users')->onDelete('set null');
            $table->foreignId('faskes_id')->nullable()->constrained('fasilitas_kesehatan')->onDelete('set null');
            $table->enum('status', ['aktif', 'sembuh', 'kronis', 'rawat_inap'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_penyakit');
    }
};
