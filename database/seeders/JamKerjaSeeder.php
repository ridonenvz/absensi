<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JamKerja;

class JamKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['hari' => 'Senin', 'jam_masuk' => '08:00', 'jam_pulang' => '16:00', 'is_wfh' => false],
            ['hari' => 'Selasa', 'jam_masuk' => '08:00', 'jam_pulang' => '16:00', 'is_wfh' => false],
            ['hari' => 'Rabu', 'jam_masuk' => '08:00', 'jam_pulang' => '16:00', 'is_wfh' => false],
            ['hari' => 'Kamis', 'jam_masuk' => '08:00', 'jam_pulang' => '16:00', 'is_wfh' => false],
            ['hari' => 'Jumat', 'jam_masuk' => '08:00', 'jam_pulang' => '16:00', 'is_wfh' => true],
        ];

        foreach ($data as $row) {
            JamKerja::updateOrCreate(['hari' => $row['hari']], $row);
        }
    }
}
