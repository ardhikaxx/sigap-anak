<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orangtua_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('nik', 20)->unique()->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('wilayah_id')->nullable()->constrained('wilayah')->onDelete('set null');
            $table->string('pekerjaan', 100)->nullable();
            $table->enum('pendidikan', ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3', 'Lainnya'])->nullable();
            $table->enum('penghasilan', ['<1jt', '1-3jt', '3-5jt', '5-10jt', '>10jt'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orangtua_profile');
    }
};
