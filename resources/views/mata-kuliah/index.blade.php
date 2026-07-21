@extends('layouts.app')

@section('title', 'Mata Kuliah')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Mata Kuliah</h1>
        <p class="page-sub">Kelola daftar mata kuliah</p>
    </div>
    <a href="{{ route('mata-kuliah.create') }}" class="btn btn-primary">+ Tambah</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mataKuliahs as $mk)
            <tr>
                <td>{{ $loop->iteration + ($mataKuliahs->currentPage() - 1) * $mataKuliahs->perPage() }}</td>
                <td><span class="badge badge-primary">{{ $mk->kode }}</span></td>
                <td class="fw-semibold">{{ $mk->nama }}</td>
                <td>{{ $mk->sks }} SKS</td>
                <td class="action-col">
                    <a href="{{ route('mata-kuliah.edit', $mk) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('mata-kuliah.destroy', $mk) }}" method="POST" onsubmit="return confirm('Hapus mata kuliah ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">Belum ada data mata kuliah.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-wrap">{{ $mataKuliahs->links() }}</div>
</div>
@endsection
