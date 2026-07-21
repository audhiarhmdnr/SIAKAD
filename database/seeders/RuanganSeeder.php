<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'GDA-101', 'nama' => 'Lab Komputer 1', 'kapasitas' => 40, 'gedung' => 'Gedung A'],
            ['kode' => 'GDA-102', 'nama' => 'Lab Komputer 2', 'kapasitas' => 40, 'gedung' => 'Gedung A'],
            ['kode' => 'GDA-201', 'nama' => 'Ruang Kelas A201', 'kapasitas' => 50, 'gedung' => 'Gedung A'],
            ['kode' => 'GDB-101', 'nama' => 'Ruang Kelas B101', 'kapasitas' => 45, 'gedung' => 'Gedung B'],
            ['kode' => 'GDB-201', 'nama' => 'Ruang Seminar B201', 'kapasitas' => 80, 'gedung' => 'Gedung B'],
            ['kode' => 'GDC-101', 'nama' => 'Ruang Kelas C101', 'kapasitas' => 35, 'gedung' => 'Gedung C'],
        ];

        foreach ($data as $d) {
            Ruangan::firstOrCreate(['kode' => $d['kode']], $d);
        }
    }
}
