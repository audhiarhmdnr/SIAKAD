<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliahs = MataKuliah::latest()->paginate(15);
        return view('mata-kuliah.index', compact('mataKuliahs'));
    }

    public function create()
    {
        return view('mata-kuliah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:mata_kuliahs',
            'nama' => 'required|string|max:255',
            'sks'  => 'required|integer|min:1|max:6',
        ]);

        MataKuliah::create($request->only('kode', 'nama', 'sks'));

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah)
    {
        return view('mata-kuliah.edit', compact('mataKuliah'));
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:mata_kuliahs,kode,' . $mataKuliah->id,
            'nama' => 'required|string|max:255',
            'sks'  => 'required|integer|min:1|max:6',
        ]);

        $mataKuliah->update($request->only('kode', 'nama', 'sks'));

        return redirect()->route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();
        return redirect()->route('mata-kuliah.index')->with('success', 'Mata kuliah berhasil dihapus.');
    }
}
