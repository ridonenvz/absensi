<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
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

            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'pegawai', 'atasan', 'pimpinan'])->default('pegawai')->after('password');
            }

            if (!Schema::hasColumn('users', 'pegawai_id')) {
                $table->foreignId('pegawai_id')->nullable()->after('role')->constrained('pegawai')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
