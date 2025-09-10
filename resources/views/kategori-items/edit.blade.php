@extends('layouts.app')
@section('content')
<div class="container">
    <h3>Edit Kategori</h3>
    <form action="{{ route('kategori-items.update', $kategori->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Kode</label>
            <input type="text" name="kode" class="form-control" value="{{ $kategori->kode }}" required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $kategori->nama }}" required>
        </div>
        <button class="btn btn-success mt-2">Update</button>
    </form>
</div>
@endsection
