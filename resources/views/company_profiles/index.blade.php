@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Company Profile</h3>
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
                    <a href="/company-profiles">Company Profile</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="/company-profiles">Data Profile</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('company-profiles.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i> Tambah Company Profile
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="company-profile-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Logo</th>
                                        <th>Nama</th>
                                        <th>Tahun Berdiri</th>
                                        <th>Visi</th>
                                        <th>Misi</th>
                                        <th style="width: 15%">Action</th>
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
<!-- edit menggunakan modals -->
<div class="modal fade" id="editCompanyProfileModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editCompanyProfileForm" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Method PUT untuk update -->
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Company Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="form-group">
                        <label for="edit-name">Nama Perusahaan</label>
                        <input type="text" class="form-control" id="edit-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-vision">Visi</label>
                        <textarea class="form-control" id="edit-vision" name="vision" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-mission">Misi</label>
                        <textarea class="form-control" id="edit-mission" name="mission" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-history">Sejarah</label>
                        <textarea class="form-control content" id="edit-history" name="history" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-description">Latar Belakang Perusahaan</label>
                        <textarea class="form-control content1" id="edit-description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-founded_year">Tahun Berdiri</label>
                        <input type="date" class="form-control" id="edit-founded_year" name="founded_year" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-structure_image">Gambar Struktur</label>
                        <input type="file" class="form-control" id="edit-structure_image" name="structure_image">
                    </div>
                    <div class="form-group">
                        <label for="edit-logo">Logo Perusahaan</label>
                        <input type="file" class="form-control" id="edit-logo" name="logo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    $(function() {
        // Inisialisasi DataTable
        $('#company-profile-table').DataTable({
            responsive: true,
            scrollX: true,
            autoWidth: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('company-profiles.index') }}", // URL menuju controller
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'logo',
                    name: 'logo'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'founded_year',
                    name: 'founded_year',
                    orderable: false,
                    searchable: false
                }, // Kolom kategori
                {
                    data: 'vision',
                    name: 'vision',
                    orderable: false,
                    searchable: false
                }, // Kolom kategori
                {
                    data: 'mission',
                    name: 'mission',
                    orderable: false,
                    searchable: false
                }, // Kolom kategori
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                } // Kolom aksi
            ]
        });
    });

    // Hapus data company profile dengan SweetAlert
    $(document).on('click', '.delete-btn', function() {
        let profileId = $(this).data('id');
        let url = "{{ route('company-profiles.destroy', ':id') }}".replace(':id', profileId);

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire('Berhasil!', response.success, 'success');
                        $('#company-profile-table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.error || 'Terjadi kesalahan.', 'error');
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        // Fungsi untuk memuat data ke dalam modal edit
        $(document).on('click', '.edit-company', function() {
            let companyId = $(this).data('id');

            let url = "{{ route('company-profiles.edit', ':id') }}".replace(':id', companyId);

            $.get(url, function(data) {
                $('#edit-id').val(data.id);
                $('#edit-name').val(data.name);
                $('#edit-vision').val(data.vision);
                $('#edit-mission').val(data.mission);
                $('#edit-history').val(data.history);
                $('#edit-description').val(data.description);
                $('#edit-founded_year').val(data.founded_year);

                // Tampilkan modal edit
                $('#editCompanyProfileModal').modal('show');
            });
        });

        // Submit form edit
        $('#editCompanyProfileForm').on('submit', function(e) {
            e.preventDefault();

            let companyId = $('#edit-id').val();
            let url = "{{ route('company-profiles.update', ':id') }}".replace(':id', companyId);
            let formData = new FormData(this);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false, // Jangan proses data
                contentType: false, // Jangan set content type
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Company profile has been updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#editCompanyProfileModal').modal('hide');
                        $('#company-profile-table').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value + '<br>';
                    });

                    Swal.fire({
                        title: 'Error!',
                        html: errorMessage,
                        icon: 'error'
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        $('.content').summernote({
            height: 300, // Tinggi editor
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            placeholder: 'Tulis konten Anda di sini...'
        });
    });

    $(document).ready(function() {
        $('.content1').summernote({
            height: 300, // Tinggi editor
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            placeholder: 'Tulis konten Anda di sini...'
        });
    });
</script>
@endpush