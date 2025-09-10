@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Kategori</h3>
    <form method="POST" action="{{ route('kategori-items.update', $kategoriItem->id) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Kode</label>
            <input type="text" name="kode" class="form-control" value="{{ $kategoriItem->kode }}" required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $kategoriItem->nama }}" required>
        </div>
        <button class="btn btn-success mt-2">Update</button>
    </form>
</div>
@endsection
