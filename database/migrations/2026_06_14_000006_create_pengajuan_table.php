<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pengajuan')) {
            Schema::create('pengajuan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
                $table->enum('jenis', ['izin', 'cuti_tahunan', 'cuti_sakit', 'cuti_melahirkan', 'cuti_penting']);
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->text('alasan');
                $table->string('lampiran')->nullable();
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
                $table->unsignedBigInteger('approved_by')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
