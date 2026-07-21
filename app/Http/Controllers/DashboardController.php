<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\Ruangan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_jadwal'      => Jadwal::count(),
            'total_dosen'       => Dosen::count(),
            'total_mk'          => MataKuliah::count(),
            'total_ruangan'     => Ruangan::count(),
        ];

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        $jadwalPerHari = collect($hariList)->mapWithKeys(function ($hari) {
            return [$hari => Jadwal::where('hari', $hari)->count()];
        });

        $mkPopuler = MataKuliah::withCount('jadwals')->orderByDesc('jadwals_count')->take(5)->get();

        $dosenTersibuk = Dosen::withCount('jadwals')->orderByDesc('jadwals_count')->take(5)->get();

        $jadwalTerbaru = Jadwal::with(['mataKuliah', 'dosen', 'ruangan'])
            ->latest()->take(6)->get();

        return view('dashboard', compact(
            'stats',
            'jadwalPerHari',
            'mkPopuler',
            'dosenTersibuk',
            'jadwalTerbaru'
        ));
    }
}
