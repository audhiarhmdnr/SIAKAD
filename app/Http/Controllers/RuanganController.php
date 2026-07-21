<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangans = Ruangan::latest()->paginate(15);
        return view('ruangan.index', compact('ruangans'));
    }

    public function create()
    {
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'      => 'required|string|max:20|unique:ruangans',
            'nama'      => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'gedung'    => 'required|string|max:100',
        ]);

        Ruangan::create($request->only('kode', 'nama', 'kapasitas', 'gedung'));

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan)
    {
        return view('ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $request->validate([
            'kode'      => 'required|string|max:20|unique:ruangans,kode,' . $ruangan->id,
            'nama'      => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'gedung'    => 'required|string|max:100',
        ]);

        $ruangan->update($request->only('kode', 'nama', 'kapasitas', 'gedung'));

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan)
    {
        $ruangan->delete();
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
