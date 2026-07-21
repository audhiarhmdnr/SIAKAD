@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Jadwal</h1>
    </div>
    <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card form-card">
    <form action="{{ route('jadwal.update', $jadwal) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group">
                <label for="mata_kuliah_id">Mata Kuliah</label>
                <select id="mata_kuliah_id" name="mata_kuliah_id" class="form-control @error('mata_kuliah_id') is-invalid @enderror" required>
                    @foreach($mataKuliahs as $mk)
                        <option value="{{ $mk->id }}" {{ old('mata_kuliah_id', $jadwal->mata_kuliah_id) == $mk->id ? 'selected' : '' }}>
                            {{ $mk->kode }} – {{ $mk->nama }}
                        </option>
                    @endforeach
                </select>
                @error('mata_kuliah_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="dosen_id">Dosen</label>
                <select id="dosen_id" name="dosen_id" class="form-control @error('dosen_id') is-invalid @enderror" required>
                    @foreach($dosens as $d)
                        <option value="{{ $d->id }}" {{ old('dosen_id', $jadwal->dosen_id) == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                    @endforeach
                </select>
                @error('dosen_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="ruangan_id">Ruangan</label>
                <select id="ruangan_id" name="ruangan_id" class="form-control @error('ruangan_id') is-invalid @enderror" required>
                    @foreach($ruangans as $r)
                        <option value="{{ $r->id }}" {{ old('ruangan_id', $jadwal->ruangan_id) == $r->id ? 'selected' : '' }}>
                            {{ $r->kode }} – {{ $r->nama }}
                        </option>
                    @endforeach
                </select>
                @error('ruangan_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="hari">Hari</label>
                <select id="hari" name="hari" class="form-control @error('hari') is-invalid @enderror" required>
                    @foreach($hariList as $h)
                        <option value="{{ $h }}" {{ old('hari', $jadwal->hari) == $h ? 'selected' : '' }}>{{ $h }}</option>
                    @endforeach
                </select>
                @error('hari')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="mulai">Jam Mulai</label>
                <input type="time" id="mulai" name="mulai" class="form-control @error('mulai') is-invalid @enderror" value="{{ old('mulai', substr($jadwal->mulai,0,5)) }}" required>
                @error('mulai')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="selesai">Jam Selesai</label>
                <input type="time" id="selesai" name="selesai" class="form-control @error('selesai') is-invalid @enderror" value="{{ old('selesai', substr($jadwal->selesai,0,5)) }}" required>
                @error('selesai')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" id="kelas" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas', $jadwal->kelas) }}" required>
                @error('kelas')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="text" id="semester" name="semester" class="form-control @error('semester') is-invalid @enderror" value="{{ old('semester', $jadwal->semester) }}" required>
                @error('semester')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Perbarui Jadwal</button>
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
