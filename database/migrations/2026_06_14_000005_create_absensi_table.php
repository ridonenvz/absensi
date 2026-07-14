<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('absensi')) {
            Schema::create('absensi', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
                $table->date('tanggal');
                $table->time('jam_masuk')->nullable();
                $table->time('jam_pulang')->nullable();
                $table->integer('menit_telat')->default(0);
                $table->integer('menit_kompensasi')->default(0);
                $table->enum('status', ['hadir', 'terlambat', 'izin', 'cuti', 'wfh']);
                $table->text('keterangan')->nullable();
                $table->timestamps();
                $table->unique(['pegawai_id', 'tanggal']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
