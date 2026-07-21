<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $semester = 'Ganjil 2024/2025';

        $slots = [
            ['mk' => 'IF101', 'dosen' => '0012345601', 'ruangan' => 'GDA-101', 'hari' => 'Senin',   'mulai' => '07:30', 'selesai' => '10:00', 'kelas' => 'A'],
            ['mk' => 'IF201', 'dosen' => '0023456702', 'ruangan' => 'GDA-201', 'hari' => 'Senin',   'mulai' => '10:00', 'selesai' => '12:30', 'kelas' => 'A'],
            ['mk' => 'IF301', 'dosen' => '0034567803', 'ruangan' => 'GDB-101', 'hari' => 'Selasa',  'mulai' => '07:30', 'selesai' => '10:00', 'kelas' => 'A'],
            ['mk' => 'IF401', 'dosen' => '0045678904', 'ruangan' => 'GDB-201', 'hari' => 'Selasa',  'mulai' => '13:00', 'selesai' => '15:30', 'kelas' => 'B'],
            ['mk' => 'MA101', 'dosen' => '0056789005', 'ruangan' => 'GDC-101', 'hari' => 'Rabu',    'mulai' => '07:30', 'selesai' => '10:00', 'kelas' => 'A'],
            ['mk' => 'IF501', 'dosen' => '0012345601', 'ruangan' => 'GDA-102', 'hari' => 'Rabu',    'mulai' => '10:00', 'selesai' => '12:00', 'kelas' => 'B'],
            ['mk' => 'IF601', 'dosen' => '0023456702', 'ruangan' => 'GDA-201', 'hari' => 'Kamis',   'mulai' => '07:30', 'selesai' => '10:00', 'kelas' => 'A'],
            ['mk' => 'MA201', 'dosen' => '0034567803', 'ruangan' => 'GDB-101', 'hari' => 'Jumat',   'mulai' => '07:30', 'selesai' => '09:30', 'kelas' => 'A'],
            ['mk' => 'IF101', 'dosen' => '0045678904', 'ruangan' => 'GDC-101', 'hari' => 'Sabtu',   'mulai' => '07:30', 'selesai' => '10:00', 'kelas' => 'B'],
        ];

        foreach ($slots as $slot) {
            $mk      = MataKuliah::where('kode', $slot['mk'])->first();
            $dosen   = Dosen::where('nidn', $slot['dosen'])->first();
            $ruangan = Ruangan::where('kode', $slot['ruangan'])->first();

            if (!$mk || !$dosen || !$ruangan) {
                continue;
            }

            Jadwal::firstOrCreate(
                [
                    'mata_kuliah_id' => $mk->id,
                    'dosen_id'       => $dosen->id,
                    'hari'           => $slot['hari'],
                    'mulai'          => $slot['mulai'],
                    'semester'       => $semester,
                ],
                [
                    'ruangan_id' => $ruangan->id,
                    'selesai'    => $slot['selesai'],
                    'kelas'      => $slot['kelas'],
                ]
            );
        }
    }
}
