@extends('layouts.app')

@section('title', 'Jadwal Kuliah')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Jadwal Kuliah</h1>
        <p class="page-sub">Daftar seluruh jadwal perkuliahan</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('jadwal.export', request()->query()) }}" class="btn btn-success">↓ Export CSV</a>
        <a href="{{ route('jadwal.grid') }}" class="btn btn-secondary">Grid View</a>
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">+ Tambah</a>
    </div>
</div>

<div class="card filter-card">
    <form method="GET" action="{{ route('jadwal.index') }}" class="filter-form">
        <div class="form-group">
            <label>Kelas</label>
            <select name="kelas" class="form-control">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k }}" {{ request('kelas') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Semester</label>
            <select name="semester" class="form-control">
                <option value="">Semua Semester</option>
                @foreach($semList as $s)
                    <option value="{{ $s }}" {{ request('semester') == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Prodi</label>
            <select name="prodi" class="form-control">
                <option value="">Semua Prodi</option>

                @foreach($prodiList as $p)
                    <option value="{{ $p->id }}"
                        {{ request('prodi') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama }}
                    </option>
                @endforeach

            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Reset</a>
    </form>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Ruangan</th>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Kelas</th>
                <th>Semester</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwals as $jadwal)
            <tr>
                <td>{{ $loop->iteration + ($jadwals->currentPage() - 1) * $jadwals->perPage() }}</td>
                <td>
                    <div class="fw-semibold">{{ $jadwal->mataKuliah->nama }}</div>
                    <small class="text-muted">{{ $jadwal->mataKuliah->kode }}</small>
                </td>
                <td>{{ $jadwal->dosen->nama }}</td>
                <td>{{ $jadwal->ruangan->kode }}</td>
                <td><span class="badge badge-day">{{ $jadwal->hari }}</span></td>
                <td>{{ substr($jadwal->mulai,0,5) }} – {{ substr($jadwal->selesai,0,5) }}</td>
                <td>{{ $jadwal->kelas }}</td>
                <td>{{ $jadwal->semester }}</td>
                <td class="action-col">
                    <a href="{{ route('jadwal.edit', $jadwal) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('jadwal.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center text-muted">Belum ada jadwal.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrap">{{ $jadwals->links() }}</div>
</div>
@endsection
