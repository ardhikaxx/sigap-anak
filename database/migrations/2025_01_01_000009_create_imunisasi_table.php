<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imunisasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained()->onDelete('cascade');
            $table->string('jenis_vaksin', 100);
            $table->string('dosis', 20)->nullable();
            $table->date('tanggal');
            $table->integer('umur_saat_ini')->nullable();
            $table->foreignId('nakes_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('faskes_id')->nullable()->constrained('fasilitas_kesehatan')->onDelete('set null');
            $table->string('nomor_batch', 50)->nullable();
            $table->text('reaksi')->nullable();
            $table->date('next_schedule')->nullable();
            $table->enum('status', ['terjadwal', 'selesai', 'terlambat', 'tidak_ada'])->default('selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imunisasi');
    }
};
