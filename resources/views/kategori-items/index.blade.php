@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Kategori</h3>

    <form method="GET" class="mb-3">
        <input type="text" name="kode" placeholder="Kode" value="{{ request('kode') }}">
        <input type="text" name="nama" placeholder="Nama" value="{{ request('nama') }}">
        <button type="submit">Filter</button>
    </form>

    <a href="{{ route('kategori-items.create') }}" class="btn btn-primary mb-2">+ Tambah Kategori</a>
    <a href="/master-items" class="btn btn-primary mb-2">Back to Master Items</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $kat)
            <tr>
                <td>{{ $kat->kode }}</td>
                <td>{{ $kat->nama }}</td>
                <td>
                    <a href="{{ route('kategori-items.show', $kat->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('kategori-items.edit', $kat->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kategori-items.destroy', $kat->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $kategori->links() }}
</div>
@endsection
