<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anak', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nik_anak', 20)->nullable();
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->decimal('berat_lahir', 5, 2)->nullable();
            $table->decimal('panjang_lahir', 5, 2)->nullable();
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('nomor_bpjs', 30)->nullable();
            $table->string('nomor_kartu_anak', 30)->nullable();
            $table->foreignId('ibu_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('ayah_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('wali_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('faskes_id')->nullable()->constrained('fasilitas_kesehatan')->onDelete('set null');
            $table->foreignId('nakes_pj_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('wilayah_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['aktif', 'pindah', 'meninggal'])->default('aktif');
            $table->text('catatan_khusus')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anak');
    }
};
