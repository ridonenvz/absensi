<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pengajuan') && !Schema::hasColumn('pengajuan', 'catatan')) {
            Schema::table('pengajuan', function (Blueprint $table) {
                $table->text('catatan')->nullable()->after('approved_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pengajuan') && Schema::hasColumn('pengajuan', 'catatan')) {
            Schema::table('pengajuan', function (Blueprint $table) {
                $table->dropColumn('catatan');
            });
        }
    }
};
