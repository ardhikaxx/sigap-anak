<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nakes_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('nip', 30)->unique()->nullable();
            $table->string('str_number', 30)->nullable();
            $table->string('spesialisasi', 100)->nullable();
            $table->foreignId('faskes_id')->nullable()->constrained('fasilitas_kesehatan')->onDelete('set null');
            $table->foreignId('wilayah_id')->nullable()->constrained()->onDelete('set null');
            $table->json('jadwal_praktek')->nullable();
            $table->string('foto_ktp', 255)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nakes_profile');
    }
};
