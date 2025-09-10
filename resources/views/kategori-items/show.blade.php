@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Kategori</h3>
    <p><strong>Kode:</strong> {{ $kategoriItem->kode }}</p>
    <p><strong>Nama:</strong> {{ $kategoriItem->nama }}</p>

    <h5>Items yang memiliki kategori ini:</h5>
   @if(!empty($items) && $items->count())
    <ul>
        @foreach($items as $item)
            <li>{{ $item->nama }}</li>
        @endforeach
    </ul>
@else
    <p class="text-muted">Tidak ada item.</p>
@endif
</div>
@endsection
