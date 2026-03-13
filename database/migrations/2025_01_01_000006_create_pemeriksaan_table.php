<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained()->onDelete('cascade');
            $table->foreignId('nakes_id')->constrained('users')->onDelete('set null');
            $table->foreignId('posyandu_id')->nullable()->constrained('fasilitas_kesehatan')->onDelete('set null');
            $table->date('tanggal_periksa');
            $table->integer('umur_bulan');
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('tinggi_badan', 5, 2);
            $table->decimal('lingkar_kepala', 5, 2)->nullable();
            $table->decimal('lingkar_lengan', 5, 2)->nullable();
            $table->decimal('lingkar_perut', 5, 2)->nullable();
            $table->decimal('lingkar_dada', 5, 2)->nullable();
            
            // Z-Score indices
            $table->decimal('bb_u_zscore', 6, 3)->nullable();
            $table->decimal('tb_u_zscore', 6, 3)->nullable();
            $table->decimal('bb_tb_zscore', 6, 3)->nullable();
            $table->decimal('imt_u_zscore', 6, 3)->nullable();
            
            // Status Gizi
            $table->enum('status_bb_u', ['gizi_buruk', 'gizi_kurang', 'gizi_baik', 'gizi_lebih', 'obesitas'])->nullable();
            $table->enum('status_tb_u', ['sangat_pendek', 'pendek', 'normal', 'tinggi'])->nullable();
            $table->enum('status_bb_tb', ['sangat_kurus', 'kurus', 'normal', 'gemuk', 'obesitas'])->nullable();
            $table->enum('status_gizi_akhir', ['normal', 'berisiko', 'stunting', 'wasting', 'underweight', 'overweight', 'obesitas', 'gizi_buruk'])->nullable();
            
            // Tanda Vital
            $table->decimal('suhu_tubuh', 4, 1)->nullable();
            $table->string('tekanan_darah', 20)->nullable();
            
            // Kondisi Klinis
            $table->enum('kondisi_umum', ['baik', 'sedang', 'buruk'])->nullable();
            $table->boolean('edema')->default(false);
            
            // Intervensi
            $table->boolean('diberikan_vit_a')->default(false);
            $table->boolean('diberikan_fe')->default(false);
            $table->boolean('diberikan_zinc')->default(false);
            $table->boolean('diberikan_pmt')->default(false);
            
            // Referral
            $table->boolean('dirujuk')->default(false);
            $table->string('tujuan_rujukan', 255)->nullable();
            $table->text('alasan_rujukan')->nullable();
            
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
