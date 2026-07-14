<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pegawai')) {
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
                    // Abaikan jika kolom sudah nullable atau driver lokal tidak mendukung ALTER ini.
                }
            }
        }

        if (!Schema::hasTable('users') && Schema::hasTable('pegawai')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->enum('role', ['admin', 'pegawai', 'atasan', 'pimpinan'])->default('pegawai');
                $table->foreignId('pegawai_id')->nullable()->constrained('pegawai')->nullOnDelete();
                $table->rememberToken();
                $table->text('two_factor_secret')->nullable();
                $table->text('two_factor_recovery_codes')->nullable();
                $table->timestamp('two_factor_confirmed_at')->nullable();
                $table->foreignId('current_team_id')->nullable();
                $table->string('profile_photo_path', 2048)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Migration pengaman. Tidak menghapus data saat rollback agar aman untuk database yang sudah terisi.
    }
};
