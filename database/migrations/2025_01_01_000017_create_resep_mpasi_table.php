<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep_mpasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_resep', 200);
            $table->text('deskripsi')->nullable();
            $table->string('gambar', 255)->nullable();
            $table->integer('usia_minimal')->nullable();
            $table->integer('usia_maksimal')->nullable();
            $table->enum('tingkat_alergen', ['rendah', 'sedang', 'tinggi'])->nullable();
            $table->json('bahan')->nullable();
            $table->json('langkah')->nullable();
            $table->json('nilai_gizi')->nullable();
            $table->integer('waktu_memasak')->nullable();
            $table->integer('porsi')->nullable();
            $table->foreignId('penulis_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_published')->default(false);
            $table->integer('likes')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep_mpasi');
    }
};
