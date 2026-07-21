@extends('layouts.app')

@section('title', 'Edit Mata Kuliah')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Mata Kuliah</h1>
    </div>
    <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card form-card">
    <form action="{{ route('mata-kuliah.update', $mataKuliah) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="kode">Kode MK</label>
            <input type="text" id="kode" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $mataKuliah->kode) }}" required>
            @error('kode')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="nama">Nama Mata Kuliah</label>
            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $mataKuliah->nama) }}" required>
            @error('nama')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="sks">SKS</label>
            <input type="number" id="sks" name="sks" class="form-control @error('sks') is-invalid @enderror" value="{{ old('sks', $mataKuliah->sks) }}" min="1" max="6" required>
            @error('sks')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('mata-kuliah.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
