<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [[0, 'desc']],
        });

        // load awal
        getData();

        // tombol filter
        $('.btn-get-data').click(function() {
            getData();
        });
    });

    function getData(){
        $('#loading-filter').show();
        let dataTableObj = $('#table').DataTable();

        // ambil filter
        let filter_kode      = $('#filter-kode').val();
        let filter_nama      = $('#filter-nama').val();
        let filter_harga_min = $('#filter-harga-min').val();
        let filter_harga_max = $('#filter-harga-max').val();
        let filter_kategori  = $('#filter-kategori').val();

        // kosongkan tabel sebelum isi
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{ url("master-items/search") }}',
            type: 'GET',
            dataType: 'json',
            data: {
                kode: filter_kode,
                nama: filter_nama,
                hargamin: filter_harga_min,
                hargamax: filter_harga_max,
                kategori: filter_kategori
            },
            success: function(results) {
                let data = results.data || [];

                $.each(data, function(index, item) {
                    let harga_beli = parseFloat(item.harga_beli) || 0;
                    let laba = parseFloat(item.laba) || 0;
                    let harga_jual = Math.round(harga_beli + (harga_beli * laba / 100));

                    let imgTag = item.img_url 
                        ? `<img src="${item.img_url}" alt="${item.nama}" width="60" height="60">` 
                        : `<span class="text-muted">No Image</span>`;

                    let actionBtn = `<a href="{{ url('master-items/view/') }}/${item.kode}" class="btn btn-primary btn-sm">View</a>`;

                    // urutan kolom
                    let array_temp = [
                        item.kode ?? '-',
                        item.nama ?? '-',
                        item.jenis ?? '-',
                        harga_beli,
                        laba,
                        harga_jual,
                        item.kategori_nama ?? '-',
                        imgTag,
                        actionBtn
                    ];

                    dataTableObj.row.add(array_temp).draw(false);
                });

                $('#loading-filter').hide();
            },
            error: function() {
                alert('Terjadi kesalahan server, tidak dapat mengambil data');
                $('#loading-filter').hide();
            }
        });
    }
</script>