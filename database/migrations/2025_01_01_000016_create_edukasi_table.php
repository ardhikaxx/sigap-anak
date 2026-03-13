<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('edukasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->longText('konten');
            $table->text('ringkasan')->nullable();
            $table->string('gambar', 255)->nullable();
            $table->enum('kategori', ['nutrisi', 'pola_makan', 'stimulasi', 'imunisasi', 'penyakit', 'resep_mpasi', 'tips_parenting']);
            $table->json('tag')->nullable();
            $table->foreignId('penulis_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('target_usia', 50)->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edukasi');
    }
};
