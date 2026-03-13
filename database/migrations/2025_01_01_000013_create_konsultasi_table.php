<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsultasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->nullable()->constrained('anak')->onDelete('cascade');
            $table->unsignedBigInteger('orangtua_id');
            $table->foreign('orangtua_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('nakes_id')->nullable();
            $table->foreign('nakes_id')->references('id')->on('users')->onDelete('set null');
            $table->enum('tipe', ['chat', 'video_call', 'tatap_muka']);
            $table->string('topik', 255);
            $table->enum('status', ['menunggu', 'aktif', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->dateTime('jadwal')->nullable();
            $table->integer('durasi_menit')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->text('ulasan')->nullable();
            $table->timestamps();
            $table->timestamp('selesai_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi');
    }
};
