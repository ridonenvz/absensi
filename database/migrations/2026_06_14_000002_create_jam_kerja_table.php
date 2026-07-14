<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('jam_kerja')) {
            Schema::create('jam_kerja', function (Blueprint $table) {
                $table->id();
                $table->string('hari')->unique();
                $table->time('jam_masuk')->nullable();
                $table->time('jam_pulang')->nullable();
                $table->boolean('is_wfh')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('jam_kerja');
    }
};
