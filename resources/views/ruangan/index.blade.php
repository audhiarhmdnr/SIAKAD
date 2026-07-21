@extends('layouts.app')

@section('title', 'Ruangan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Ruangan</h1>
        <p class="page-sub">Kelola daftar ruang kuliah</p>
    </div>
    <a href="{{ route('ruangan.create') }}" class="btn btn-primary">+ Tambah</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode</th>
                <th>Nama Ruangan</th>
                <th>Gedung</th>
                <th>Kapasitas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ruangans as $ruangan)
            <tr>
                <td>{{ $loop->iteration + ($ruangans->currentPage() - 1) * $ruangans->perPage() }}</td>
                <td><span class="badge badge-success">{{ $ruangan->kode }}</span></td>
                <td class="fw-semibold">{{ $ruangan->nama }}</td>
                <td>{{ $ruangan->gedung }}</td>
                <td>{{ $ruangan->kapasitas }} orang</td>
                <td class="action-col">
                    <a href="{{ route('ruangan.edit', $ruangan) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('ruangan.destroy', $ruangan) }}" method="POST" onsubmit="return confirm('Hapus ruangan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Belum ada data ruangan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrap">{{ $ruangans->links() }}</div>
</div>
@endsection
