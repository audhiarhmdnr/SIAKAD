@extends('layouts.app')

@section('title', 'Dosen')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Data Dosen</h1>
        <p class="page-sub">Kelola data dosen pengampu mata kuliah</p>
    </div>
    <a href="{{ route('dosen.create') }}" class="btn btn-primary">+ Tambah Dosen</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>NIDN</th>
                <th>Email</th>
                <th>Jumlah Jadwal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dosens as $dosen)
            <tr>
                <td>{{ $loop->iteration + ($dosens->currentPage() - 1) * $dosens->perPage() }}</td>
                <td class="fw-semibold">{{ $dosen->nama }}</td>
                <td><span class="badge badge-info">{{ $dosen->nidn }}</span></td>
                <td>{{ $dosen->email }}</td>
                <td>{{ $dosen->jadwals_count ?? $dosen->jadwals()->count() }}</td>
                <td class="action-col">
                    <a href="{{ route('dosen.edit', $dosen) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('dosen.destroy', $dosen) }}" method="POST" onsubmit="return confirm('Hapus dosen ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Belum ada data dosen.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrap">{{ $dosens->links() }}</div>
</div>
@endsection
