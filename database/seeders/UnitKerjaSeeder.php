<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitKerja;

class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Sekretariat', 'Divisi SDM', 'Divisi Hukum', 'Divisi Pengawasan'] as $nama) {
            UnitKerja::updateOrCreate(['nama_unit' => $nama], ['nama_unit' => $nama]);
        }
    }
}
