<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kehadiran_posyandu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwal_posyandu')->onDelete('cascade');
            $table->foreignId('anak_id')->constrained()->onDelete('cascade');
            $table->boolean('hadir')->default(false);
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
            
            $table->unique(['jadwal_id', 'anak_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran_posyandu');
    }
};
