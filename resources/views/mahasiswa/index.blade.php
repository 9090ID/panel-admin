@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Mahasiswa</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="/mhs">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="/mhs">Mahasiswa</a>
                </li>
            </ul>
        </div>
        <div class="description">
            <div class="col-md-12">

                <p>Gunakan tombol <strong style="color: red;">Download Format Excel</strong> untuk mengunduh template Excel yang dapat Anda gunakan untuk mengisi data mahasiswa. Setelah mengisi data pada template tersebut, Anda dapat mengimpor data dengan mengklik tombol <strong style="color: red;">Import Excel</strong> dan memilih file yang telah diisi.
            <span style="color: red;"><br>Dilarang mengubah format excel yang didownload.</span></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-success btn-round ms-3" id="downloadFormatButton">
                                <i class="fa fa-download"></i> Download Format Excel
                            </button>
                            <!-- Import Button -->
                            <button class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fa fa-file-excel"></i> Import Excel
                            </button>
                            <button id="deleteAllButton" class="btn btn-danger btn-round ms-3">
                                <i class="fa fa-trash"></i> Hapus Semua Data
                            </button>


                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mahasiswa-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="width: 40px;">Nama</th>
                                        <th>NIM</th>
                                        <th style="width: 30px;">Program Studi</th>
                                        <th>Angkatan</th>
                                        <th>Nomor Hp</th>
                                        <th>Email</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="importForm" action="{{ route('mahasiswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file">Pilih File Excel</label>
                        <input type="file" class="form-control" name="file" id="file" accept=".xlsx, .xls" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        // Initialize DataTable
        $('#mahasiswa-table').DataTable({
            responsive: true, // Menambahkan responsivitas
            scrollX: true, // Menambahkan scroll horizontal
            autoWidth: true, // Mengatur lebar otomatis pada kolom
            processing: true, // Menampilkan processing spinner saat memuat data
            serverSide: true, // Mengaktifkan server-side processing
            ajax: "{{ route('mhs.index') }}", // Endpoint Ajax
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'nim',
                    name: 'nim'
                },
                {
                    data: 'prodi.namaprodi',
                    name: 'prodi.namaprodi'
                }, // Relasi ke Prodi
                {
                    data: 'angkatan',
                    name: 'angkatan'
                },
                {
                    data: 'no_hp',
                    name: 'no_hp'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: false,
                //     searchable: false
                // },
            ]
        });

        // Import Form Submission with SweetAlert
        $('#importForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire('Berhasil!', response.message, 'success');
                    $('#importModal').modal('hide');
                    $('#mahasiswa-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal!', xhr.responseJSON?.message || 'Terjadi kesalahan.', 'error');
                }
            });
        });
    });
    //untuk download
    $('#downloadFormatButton').on('click', function() {
        window.location.href = "{{ route('khusus.downloadformat') }}";
    });
    // hapus all data
    $('#deleteAllButton').on('click', function() {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Semua data mahasiswa akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('khusus.delete-all') }}",
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire('Berhasil!', response.message, 'success');
                    // Menambahkan reload halaman setelah penghapusan berhasil
                    location.reload();  // Reload seluruh halaman
                    // Atau, jika menggunakan DataTable, reload data saja:
                    // $('#mahasiswa-table').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                }
            });
        }
    });
});



</script>
@endpush