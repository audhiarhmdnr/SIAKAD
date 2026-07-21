@extends('layouts.app')

@section('title', 'Edit Dosen')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Dosen</h1>
        <p class="page-sub">Perbarui data dosen</p>
    </div>
    <a href="{{ route('dosen.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card form-card">
    <form action="{{ route('dosen.update', $dosen) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $dosen->nama) }}" required>
            @error('nama')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="nidn">NIDN</label>
            <input type="text" id="nidn" name="nidn" class="form-control @error('nidn') is-invalid @enderror" value="{{ old('nidn', $dosen->nidn) }}" required>
            @error('nidn')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $dosen->email) }}" required>
            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
