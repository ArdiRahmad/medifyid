<form method="POST" enctype="multipart/form-data">
    @csrf
    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required  value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required  value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required  value="{{$item->laba ?? ''}}">
    </div>

   @php $selected = $item->kategori_item_id ?? ''; @endphp
    <div class="form-group">
        <label>Kategori</label>
        <select class="form-control" required name="kategori_item_id">
            <option value="">--Pilih--</option>
            @foreach($kategoriItems as $kategori)
                <option value="{{ $kategori->id }}" 
                    @if($selected == $kategori->id) selected @endif>
                    {{ $kategori->nama }}
                </option>
            @endforeach
        </select>
    </div>


    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif>Obat</option>
            <option @if($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if($selected == 'Matkes') selected @endif>Matkes</option>
            <optio @if($selected == 'Umum') selected @endif>Umum</option>
            <optio @if($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

     <div class="form-group">
        <label>Upload Gambar</label>
        <input type="file" class="form-control" name="img_url" accept="image/*">
        @if(!empty($item->img_url))
            <div class="mt-2">
                <img src="{{ asset($item->img_url) }}" alt="Preview" width="100">
            </div>
        @endif
    </div>
    <button class="btn btn-primary mt-3">Submit</button>

</form>