<?php

namespace Database\Seeders;

use App\Models\Dosen;
use Illuminate\Database\Seeder;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Dr. Ahmad Fauzi, M.Kom', 'nidn' => '0012345601', 'email' => 'ahmad.fauzi@kalla.ac.id'],
            ['nama' => 'Siti Rahmawati, S.T., M.T.', 'nidn' => '0023456702', 'email' => 'siti.rahmawati@kalla.ac.id'],
            ['nama' => 'Budi Santoso, M.Cs', 'nidn' => '0034567803', 'email' => 'budi.santoso@kalla.ac.id'],
            ['nama' => 'Nurul Hidayah, M.Kom', 'nidn' => '0045678904', 'email' => 'nurul.hidayah@kalla.ac.id'],
            ['nama' => 'Hendra Wijaya, Ph.D', 'nidn' => '0056789005', 'email' => 'hendra.wijaya@kalla.ac.id'],
        ];

        foreach ($data as $d) {
            Dosen::firstOrCreate(['nidn' => $d['nidn']], $d);
        }
    }
}
