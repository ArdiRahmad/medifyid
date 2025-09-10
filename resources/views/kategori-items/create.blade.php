@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Kategori</h3>
    <form method="POST" action="{{ route('kategori-items.store') }}">
        @csrf
        <div class="form-group">
            <label>Kode</label>
            <input type="text" name="kode" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <button class="btn btn-success mt-2">Simpan</button>
    </form>
</div>
@endsection
