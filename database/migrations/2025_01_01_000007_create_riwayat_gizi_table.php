<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_gizi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak')->onDelete('cascade');
            $table->foreignId('pemeriksaan_id')->nullable()->constrained('pemeriksaan')->onDelete('set null');
            $table->unsignedBigInteger('nakes_id')->nullable();
            $table->foreign('nakes_id')->references('id')->on('users')->onDelete('set null');
            $table->string('diagnosis_gizi', 255)->nullable();
            $table->string('kode_icd', 20)->nullable();
            $table->text('intervensi')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->decimal('target_bb', 5, 2)->nullable();
            $table->decimal('target_tb', 5, 2)->nullable();
            $table->date('follow_up_date')->nullable();
            $table->enum('status_kasus', ['baru', 'dalam_penanganan', 'membaik', 'sembuh', 'dirujuk', 'dropout'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_gizi');
    }
};
