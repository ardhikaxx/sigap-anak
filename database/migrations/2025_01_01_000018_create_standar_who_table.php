<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standar_who', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->integer('umur_bulan');
            $table->enum('indikator', ['BB_U', 'TB_U', 'BB_TB', 'IMT_U']);
            $table->decimal('sd_minus3', 6, 3)->nullable();
            $table->decimal('sd_minus2', 6, 3)->nullable();
            $table->decimal('sd_minus1', 6, 3)->nullable();
            $table->decimal('median', 6, 3)->nullable();
            $table->decimal('sd_plus1', 6, 3)->nullable();
            $table->decimal('sd_plus2', 6, 3)->nullable();
            $table->decimal('sd_plus3', 6, 3)->nullable();
            
            $table->unique(['jenis_kelamin', 'umur_bulan', 'indikator']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standar_who');
    }
};
