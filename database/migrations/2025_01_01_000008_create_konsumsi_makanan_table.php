<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsumsi_makanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('waktu_makan', ['pagi', 'selingan_pagi', 'siang', 'selingan_sore', 'malam', 'tengah_malam']);
            $table->string('nama_makanan', 150);
            $table->decimal('porsi', 6, 2)->nullable();
            $table->string('satuan', 50)->nullable();
            $table->decimal('kalori', 8, 2)->nullable();
            $table->decimal('protein', 6, 2)->nullable();
            $table->decimal('lemak', 6, 2)->nullable();
            $table->decimal('karbohidrat', 6, 2)->nullable();
            $table->decimal('serat', 6, 2)->nullable();
            $table->decimal('vitamin_a', 8, 4)->nullable();
            $table->decimal('vitamin_c', 8, 4)->nullable();
            $table->decimal('kalsium', 8, 2)->nullable();
            $table->decimal('zat_besi', 8, 4)->nullable();
            $table->decimal('zinc', 8, 4)->nullable();
            $table->enum('inputter_role', ['orangtua', 'nakes']);
            $table->foreignId('inputter_id')->constrained('users')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsumsi_makanan');
    }
};
