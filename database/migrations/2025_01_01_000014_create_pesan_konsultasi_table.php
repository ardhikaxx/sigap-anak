<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesan_konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konsultasi_id')->constrained()->onDelete('cascade');
            $table->foreignId('pengirim_id')->constrained('users')->onDelete('cascade');
            $table->text('pesan');
            $table->enum('tipe', ['text', 'image', 'file', 'voice'])->default('text');
            $table->string('file_path', 255)->nullable();
            $table->boolean('dibaca')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan_konsultasi');
    }
};
