@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Daftar Buku</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="/users">
                        <i class="icon-user"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="/buku">Buku</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="/buku">Daftar Buku</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary mb-3 btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#createBukuModal">
                                <i class="fas fa-plus"></i> Tambah Buku
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buku-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Penulis</th>
                                        <th>Penerbit</th>
                                        <th>Tahun Terbit</th>
                                        <th>Files Buku</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimuat menggunakan DataTables via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="createBukuModal" tabindex="-1" aria-labelledby="createBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBukuModalLabel">Tambah Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createBukuForm" action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="judul">Judul Buku</label>
                        <input type="text" name="judul" id="judul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis">Penulis</label>
                        <input type="text" name="penulis" id="penulis" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="penerbit">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun_terbit">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file_buku">File Buku</label>
                        <input type="file" name="file_buku" id="file_buku" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="createBukuForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Buku -->
<div class="modal fade" id="editBukuModal" tabindex="-1" aria-labelledby="editBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editBuku">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editBukuModalLabel">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="bukuId" name="id">
                    <div class="mb-3">
                        <label for="editJudul" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="editJudul" name="judul">
                    </div>
                    <div class="mb-3">
                        <label for="editPenulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="editPenulis" name="penulis">
                    </div>
                    <div class="mb-3">
                        <label for="editPenerbit" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" id="editPenerbit" name="penerbit" >
                    </div>
                    <div class="mb-3">
                        <label for="editTahunTerbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="editTahunTerbit" name="tahun_terbit" >
                    </div>
                    <div class="mb-3">
                        <label for="editDeskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="editDeskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editFileBuku" class="form-label">File Buku</label>
                        <!-- Tautan untuk melihat file -->
                        <div id="fileBukuLink" class="mb-2">
                            <!-- Tautan akan diisi melalui JavaScript -->
                        </div>
                        <!-- Input untuk mengganti file -->
                        <input type="file" class="form-control" id="editFileBuku" name="file_buku">
                    </div>
                    
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-control" id="editStatus" name="status" >
                            <option value="Tersedia">Tersedia</option>
                            <option value="Tidak Tersedia">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // DataTables Initialization
        $('#buku-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('buku.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'judul', name: 'judul' },
                { data: 'penulis', name: 'penulis' },
                { data: 'penerbit', name: 'penerbit' },
                { data: 'tahun_terbit', name: 'tahun_terbit' },
                { data: 'file_buku', name: 'file_buku' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // SweetAlert2 for delete action
        $(document).on('click', '.delete-buku', function() {
            let bukuId = $(this).data('id');
            let url = "{{ route('buku.destroy', ':id') }}".replace(':id', bukuId);

            Swal.fire({
                title: 'Hapus Buku?',
                text: "Buku ini akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            Swal.fire(
                                'Dihapus!',
                                'Buku telah dihapus.',
                                'success'
                            );
                            $('#buku-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghapus buku.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

    });
     
    $(document).on('click', '.editBuku', function() {
    let bukuId = $(this).data('id'); // Ambil ID buku dari tombol

    $.ajax({
        url: "/buku/" + bukuId, // URL untuk mengambil data buku berdasarkan ID
        type: 'GET',
        success: function(response) {
            // Isi form dengan data buku
            $('#bukuId').val(response.id);
            $('#editJudul').val(response.judul);
            $('#editPenulis').val(response.penulis);
            $('#editPenerbit').val(response.penerbit);
            $('#editTahunTerbit').val(response.tahun_terbit);
            $('#editDeskripsi').val(response.deskripsi);
            $('#editStatus').val(response.status);

            // Menampilkan link file buku jika ada
            if (response.file_buku) {
                $('#currentFileBuku').html('<a href="' + response.file_buku_url + '" target="_blank">Lihat File</a>');
            } else {
                $('#currentFileBuku').html('File tidak tersedia');
            }

            // Tampilkan modal edit
            $('#editBukuModal').modal('show');
        },
        error: function(xhr) {
            Swal.fire('Error', 'Data buku tidak ditemukan.', 'error');
        }
    });
});
$('#editBuku').on('submit', function(e) {
    e.preventDefault();
    let bukuId = $(this).data('id');
    // let bukuId = $('#edit-id').val();  // Get the ID of the book
    let url = "{{ route('buku.update', ':id') }}".replace(':id', bukuId);  // Ensure bukuId is correctly passed

    let formData = new FormData(this);  // Get the form data, including the file

    // Add CSRF token to the form data
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('_method', 'PUT'); // Laravel expects PUT for updates

    $.ajax({
        url: url,
        type: 'POST',  // POST is used because we are sending form data
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            $('#editBukuModal').modal('hide');  // Close the modal
            $('#buku-table').DataTable().ajax.reload();  // Reload the table data
            Swal.fire('Success', 'Buku berhasil diperbarui!', 'success');
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText); // For debugging
            Swal.fire('Error', 'Terjadi kesalahan saat memperbarui buku', 'error');
        }
    });
});


      

    $(document).ready(function() {
        // AJAX untuk menyimpan data buku
        $('#createBukuForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman

            let formData = new FormData(this); // Ambil data form
            let url = "{{ route('buku.store') }}"; // URL untuk menambah buku

            // SweetAlert2 konfirmasi
            Swal.fire({
                title: 'Tambah Buku?',
                text: "Data buku baru akan ditambahkan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Tambah',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim data melalui AJAX
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire(
                                'Berhasil!',
                                'Buku baru berhasil ditambahkan.',
                                'success'
                            );
                            // Menutup modal
                            $('#createBukuModal').modal('hide');
                            // Reload DataTable
                            $('#buku-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menambahkan buku.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
