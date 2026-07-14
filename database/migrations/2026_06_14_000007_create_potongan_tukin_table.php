<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('potongan_tukin')) {
            Schema::create('potongan_tukin', function (Blueprint $table) {
                $table->id();
                $table->foreignId('pegawai_id')->constrained('pegawai')->cascadeOnDelete();
                $table->integer('bulan');
                $table->integer('tahun');
                $table->integer('total_telat')->default(0);
                $table->integer('total_kompensasi')->default(0);
                $table->decimal('potongan', 15, 2)->default(0);
                $table->timestamps();
                $table->unique(['pegawai_id', 'bulan', 'tahun']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('potongan_tukin');
    }
};
