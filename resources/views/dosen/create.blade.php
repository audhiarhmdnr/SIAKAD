@extends('layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Dosen</h1>
        <p class="page-sub">Isi data dosen baru</p>
    </div>
    <a href="{{ route('dosen.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card form-card">
    <form action="{{ route('dosen.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
            @error('nama')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="nidn">NIDN</label>
            <input type="text" id="nidn" name="nidn" class="form-control @error('nidn') is-invalid @enderror" value="{{ old('nidn') }}" placeholder="Nomor Induk Dosen Nasional" required>
            @error('nidn')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@kalla.ac.id" required>
            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
