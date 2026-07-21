<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\Ruangan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class JadwalController extends Controller
{
    private array $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

    public function index(Request $request)
    {
        $query = Jadwal::with([
            'mataKuliah.prodi',
            'dosen',
            'ruangan'
        ]);

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('prodi')) {
            $query->whereHas('mataKuliah', function ($q) use ($request) {
                $q->where('prodi_id', $request->prodi);
            });
        }

        $jadwals = $query
            ->orderBy('hari')
            ->orderBy('mulai')
            ->paginate(20)
            ->withQueryString();


        $kelasList = Jadwal::distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        $semList = Jadwal::distinct()
            ->orderBy('semester')
            ->pluck('semester');

        $prodiList = Prodi::orderBy('nama')->get();


        return view('jadwal.index', compact(
            'jadwals',
            'kelasList',
            'semList',
            'prodiList'
        ));
    }

    public function grid(Request $request)
    {
        $query = Jadwal::with(['mataKuliah', 'dosen', 'ruangan']);

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $jadwals   = $query->orderBy('mulai')->get()->groupBy('hari');
        $hariList  = $this->hariList;
        $kelasList = Jadwal::distinct()->orderBy('kelas')->pluck('kelas');
        $semList   = Jadwal::distinct()->orderBy('semester')->pluck('semester');

        return view('jadwal.grid', compact('jadwals', 'hariList', 'kelasList', 'semList'));
    }

    public function create()
    {
        $dosens      = Dosen::orderBy('nama')->get();
        $mataKuliahs = MataKuliah::with('prodi')
            ->orderBy('nama')
            ->get();
        $ruangans    = Ruangan::orderBy('nama')->get();
        $hariList    = $this->hariList;

        return view('jadwal.create', compact('dosens', 'mataKuliahs', 'ruangans', 'hariList'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id'       => 'required|exists:dosens,id',
            'ruangan_id'     => 'required|exists:ruangans,id',
            'hari'           => 'required|in:' . implode(',', $this->hariList),
            'mulai'          => 'required|date_format:H:i',
            'selesai'        => 'required|date_format:H:i|after:mulai',
            'kelas'          => 'required|string|max:10',
            'semester'       => 'required|string|max:20',
        ]);

        $this->cekBentrok($data);

        Jadwal::create($data);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        $dosens      = Dosen::orderBy('nama')->get();
        $mataKuliahs = MataKuliah::orderBy('nama')->get();
        $ruangans    = Ruangan::orderBy('nama')->get();
        $hariList    = $this->hariList;

        return view('jadwal.edit', compact('jadwal', 'dosens', 'mataKuliahs', 'ruangans', 'hariList'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $data = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id'       => 'required|exists:dosens,id',
            'ruangan_id'     => 'required|exists:ruangans,id',
            'hari'           => 'required|in:' . implode(',', $this->hariList),
            'mulai'          => 'required|date_format:H:i',
            'selesai'        => 'required|date_format:H:i|after:mulai',
            'kelas'          => 'required|string|max:10',
            'semester'       => 'required|string|max:20',
        ]);

        $this->cekBentrok($data, $jadwal->id);

        $jadwal->update($data);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function exportCsv(Request $request)
    {
        $query = Jadwal::with(['mataKuliah', 'dosen', 'ruangan']);

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $jadwals = $query->orderBy('hari')->orderBy('mulai')->get();

        $filename = 'jadwal_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($jadwals) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Mata Kuliah', 'Kode MK', 'Dosen', 'NIDN', 'Ruangan', 'Gedung', 'Hari', 'Mulai', 'Selesai', 'Kelas', 'Semester']);

            foreach ($jadwals as $j) {
                fputcsv($file, [
                    $j->mataKuliah->nama,
                    $j->mataKuliah->kode,
                    $j->dosen->nama,
                    $j->dosen->nidn,
                    $j->ruangan->nama,
                    $j->ruangan->gedung,
                    $j->hari,
                    $j->mulai,
                    $j->selesai,
                    $j->kelas,
                    $j->semester,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function cekBentrok(array $data, ?int $excludeId = null): void
    {
        $base = Jadwal::where('hari', $data['hari'])
            ->where(function ($q) use ($data) {
                $q->whereBetween('mulai', [$data['mulai'], $data['selesai']])
                    ->orWhereBetween('selesai', [$data['mulai'], $data['selesai']])
                    ->orWhere(function ($q2) use ($data) {
                        $q2->where('mulai', '<=', $data['mulai'])
                            ->where('selesai', '>=', $data['selesai']);
                    });
            });

        if ($excludeId) {
            $base->where('id', '!=', $excludeId);
        }

        $bentrokRuangan = (clone $base)->where('ruangan_id', $data['ruangan_id'])->first();
        if ($bentrokRuangan) {
            throw ValidationException::withMessages([
                'ruangan_id' => "Ruangan sudah dipakai pada hari {$data['hari']} pukul {$data['mulai']}–{$data['selesai']}.",
            ]);
        }

        $bentrokDosen = (clone $base)->where('dosen_id', $data['dosen_id'])->first();
        if ($bentrokDosen) {
            throw ValidationException::withMessages([
                'dosen_id' => "Dosen sudah mengajar pada hari {$data['hari']} pukul {$data['mulai']}–{$data['selesai']}.",
            ]);
        }
    }
}
