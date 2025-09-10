@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Kategori</h3>

    {{-- Filter Form --}}
    <form method="GET" class="row mb-3">
        <div class="col-md-3">
            <input type="text" name="kode" class="form-control" placeholder="Kode" value="{{ request('kode') }}">
        </div>
        <div class="col-md-3">
            <input type="text" name="nama" class="form-control" placeholder="Nama" value="{{ request('nama') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('kategori-items.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    {{-- Tombol Aksi --}}
    <div class="mb-3">
        <a href="{{ route('kategori-items.create') }}" class="btn btn-success">+ Tambah Kategori</a>
        <a href="{{ url('master-items') }}" class="btn btn-outline-primary">← Kembali ke Master Items</a>
    </div>

    {{-- Tabel Kategori --}}
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th width="100">Kode</th>
                <th>Nama</th>
                <th width="200">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategori as $kat)
            <tr>
                <td>{{ $kat->kode }}</td>
                <td>{{ $kat->nama }}</td>
                <td>
                    <a href="{{ route('kategori-items.show', $kat->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('kategori-items.edit', $kat->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kategori-items.destroy', $kat->id) }}" method="POST" style="display:inline;">
                        @csrf 
                        @method('DELETE')
                        <button onclick="return confirm('Yakin hapus kategori ini?')" class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted">Tidak ada kategori ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $kategori->links() }}
    </div>
</div>
@endsection
