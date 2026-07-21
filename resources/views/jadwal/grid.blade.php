@extends('layouts.app')

@section('title', 'Grid Jadwal Mingguan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Grid Jadwal Mingguan</h1>
        <p class="page-sub">Tampilan jadwal per hari</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('jadwal.export', request()->query()) }}" class="btn btn-success">↓ Export CSV</a>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">List View</a>
        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">+ Tambah</a>
    </div>
</div>

<div class="card filter-card">
    <form method="GET" action="{{ route('jadwal.grid') }}" class="filter-form">
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
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('jadwal.grid') }}" class="btn btn-secondary">Reset</a>
    </form>
</div>

<div class="grid-container">
    @foreach($hariList as $hari)
    <div class="grid-day-col">
        <div class="grid-day-header">{{ $hari }}</div>
        <div class="grid-slots">
            @forelse($jadwals->get($hari, collect()) as $j)
            <div class="grid-slot">
                <div class="slot-time">{{ substr($j->mulai,0,5) }} – {{ substr($j->selesai,0,5) }}</div>
                <div class="slot-mk">{{ $j->mataKuliah->nama }}</div>
                <div class="slot-meta">{{ $j->dosen->nama }}</div>
                <div class="slot-meta">{{ $j->ruangan->kode }} · {{ $j->kelas }}</div>
            </div>
            @empty
            <div class="grid-empty">—</div>
            @endforelse
        </div>
    </div>
    @endforeach
</div>
@endsection
