@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Program Studi</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="/">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="/prodi">Program Studi</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                        <a href="{{ route('prodi-inisma.create') }}" class="btn btn-primary btn-round ms-auto">
                        <i class="fa fa-plus"></i> Tambah Prodi</a> 
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="prodi-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Prodi</th>
                                        <th>Kode</th>
                                        <th>Jenjang</th>
                                        <th>Fakultas</th>
                                        <th>Ketua Prodi</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
    let table = $('#prodi-table').DataTable({
        responsive: true,
        scrollX: true,
        autoWidth: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('prodi-inisma.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'namaprodi', name: 'namaprodi' },
            { data: 'kodeprodi', name: 'kodeprodi' },
            { data: 'jenjang', name: 'jenjang' },
            { data: 'fakultas', name: 'fakultas' },  // Menampilkan nama fakultas
            { data: 'ketua_prodi', name: 'ketua_prodi' },  // Menampilkan nama ketua prodi
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

        // Hapus Prodi
        $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault(); // Mencegah aksi default

        var id = $(this).data('id'); // Ambil ID dari tombol yang diklik

        // Tanyakan konfirmasi penghapusan
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Lakukan penghapusan melalui AJAX
                $.ajax({
                    url: '{{ url("prodi-inisma") }}/' + id, // URL untuk menghapus data
                    type: 'DELETE',  // Metode pengiriman DELETE
                    data: {
                        _token: '{{ csrf_token() }}', // Kirim token CSRF
                    },
                    success: function(response) {
                        // Tampilkan notifikasi sukses menggunakan SweetAlert
                        Swal.fire(
                            'Dihapus!',
                            'Program Studi berhasil dihapus.',
                            'success'
                        ).then(() => {
                            // Refresh halaman atau hapus baris yang dihapus
                            location.reload();  // Reload halaman
                        });
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan notifikasi error jika terjadi kesalahan
                        Swal.fire(
                            'Terjadi Kesalahan!',
                            'Data gagal dihapus.',
                            'error'
                        );
                    }
                });
            }
        });
    });
    
</script>
@endpush
