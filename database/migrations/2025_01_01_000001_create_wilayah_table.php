<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->enum('tipe', ['provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'rw', 'rt']);
            $table->foreignId('parent_id')->nullable()->constrained('wilayah')->onDelete('cascade');
            $table->string('kode_pos', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};
