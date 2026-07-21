@extends('layouts.app')

@section('title', 'Edit Ruangan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Ruangan</h1>
    </div>
    <a href="{{ route('ruangan.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card form-card">
    <form action="{{ route('ruangan.update', $ruangan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="kode">Kode Ruangan</label>
            <input type="text" id="kode" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $ruangan->kode) }}" required>
            @error('kode')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="nama">Nama Ruangan</label>
            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $ruangan->nama) }}" required>
            @error('nama')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="gedung">Gedung</label>
            <input type="text" id="gedung" name="gedung" class="form-control @error('gedung') is-invalid @enderror" value="{{ old('gedung', $ruangan->gedung) }}" required>
            @error('gedung')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="kapasitas">Kapasitas</label>
            <input type="number" id="kapasitas" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror" value="{{ old('kapasitas', $ruangan->kapasitas) }}" min="1" required>
            @error('kapasitas')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('ruangan.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
