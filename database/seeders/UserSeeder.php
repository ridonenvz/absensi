<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $unit = UnitKerja::firstOrCreate(['nama_unit' => 'Sekretariat']);

        $admin = User::updateOrCreate(
            ['email' => 'admin@bawaslu.go.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'pegawai_id' => null,
            ]
        );

        $sample = [
            [
                'nip' => '198801012010011001',
                'nama' => 'Pegawai',
                'jabatan' => 'Staf Administrasi',
                'jenis_kelamin' => 'L',
                'email' => 'pegawai@bawaslu.go.id',
                'role' => 'pegawai',
            ],
            [
                'nip' => '198002022006041001',
                'nama' => 'Atasan',
                'jabatan' => 'Kepala Bagian',
                'jenis_kelamin' => 'P',
                'email' => 'atasan@bawaslu.go.id',
                'role' => 'atasan',
            ],
            [
                'nip' => '197501012001121001',
                'nama' => 'Pimpinan',
                'jabatan' => 'Pimpinan',
                'jenis_kelamin' => 'L',
                'email' => 'pimpinan@bawaslu.go.id',
                'role' => 'pimpinan',
            ],
        ];

        foreach ($sample as $row) {
            $pegawai = Pegawai::updateOrCreate(
                ['nip' => $row['nip']],
                [
                    'nama' => $row['nama'],
                    'jabatan' => $row['jabatan'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'unit_kerja_id' => $unit->id,
                    'status' => 'aktif',
                ]
            );

            User::updateOrCreate(
                ['email' => $row['email']],
                [
                    'name' => $row['nama'],
                    'password' => Hash::make('password'),
                    'role' => $row['role'],
                    'pegawai_id' => $pegawai->id,
                ]
            );
        }
    }
}
