<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_posyandu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faskes_id')->constrained('fasilitas_kesehatan')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            $table->string('tema', 200)->nullable();
            $table->text('lokasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('nakes_pj_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['terjadwal', 'sedang_berlangsung', 'selesai', 'dibatalkan'])->default('terjadwal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_posyandu');
    }
};
