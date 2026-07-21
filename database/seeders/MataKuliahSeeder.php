<?php

namespace Database\Seeders;

use App\Models\MataKuliah;
use Illuminate\Database\Seeder;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'IF101', 'nama' => 'Pemrograman Dasar', 'sks' => 3],
            ['kode' => 'IF201', 'nama' => 'Struktur Data', 'sks' => 3],
            ['kode' => 'IF301', 'nama' => 'Basis Data', 'sks' => 3],
            ['kode' => 'IF401', 'nama' => 'Rekayasa Perangkat Lunak', 'sks' => 3],
            ['kode' => 'IF501', 'nama' => 'Jaringan Komputer', 'sks' => 2],
            ['kode' => 'IF601', 'nama' => 'Kecerdasan Buatan', 'sks' => 3],
            ['kode' => 'MA101', 'nama' => 'Matematika Diskrit', 'sks' => 3],
            ['kode' => 'MA201', 'nama' => 'Aljabar Linear', 'sks' => 2],
        ];

        foreach ($data as $d) {
            MataKuliah::firstOrCreate(['kode' => $d['kode']], $d);
        }
    }
}
