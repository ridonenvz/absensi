<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pegawai')) {
            Schema::create('pegawai', function (Blueprint $table) {
                $table->id();
                $table->string('nip')->nullable()->unique();
                $table->string('nik')->nullable()->unique();
                $table->string('nama');
                $table->string('jabatan');
                $table->enum('jenis_kelamin', ['L', 'P']);
                $table->foreignId('unit_kerja_id')->constrained('unit_kerja')->cascadeOnDelete();
                $table->unsignedBigInteger('atasan_id')->nullable();
                $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
                $table->timestamps();
            });

            return;
        }

        if (!Schema::hasColumn('pegawai', 'nik')) {
            Schema::table('pegawai', function (Blueprint $table) {
                $table->string('nik')->nullable()->unique()->after('nip');
            });
        }

        if (Schema::hasColumn('pegawai', 'nip')) {
            try {
                if (DB::getDriverName() === 'mysql') {
                    DB::statement('ALTER TABLE pegawai MODIFY nip VARCHAR(255) NULL');
                }
            } catch (Throwable $e) {
                // Abaikan jika struktur database lokal sudah sesuai atau driver tidak mendukung ALTER ini.
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
