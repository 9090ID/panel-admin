@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Fakultas</h3>
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
                    <a href="#">Fakultas</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                        <button class="btn btn-primary mb-3 btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#createFakultasModal">
                                <i class="fas fa-plus"></i> Tambah Fakultas
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="fakultas-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto Fakultas</th>
                                        <th>Nama Fakultas</th>
                                        <!-- <th>Visi</th> -->
                                        <!-- <th>Misi</th> -->
                                        <th>Akreditasi</th>
                                        <th>Dekan</th>
                                        <th style="width: 10px;">Action</th>
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
<!-- Modal Create Fakultas -->
<div class="modal fade" id="createFakultasModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="createFakultasForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Fakultas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="form-group">
                        <label for="edit-namafakultas">Nama Fakultas</label>
                        <input type="text" class="form-control"  name="namafakultas" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-visi">Visi</label>
                        <textarea class="form-control"  name="visi" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-misi">Misi</label>
                        <textarea class="form-control content"  name="misi" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-deskripsi_singkat">Deskripsi Singkat</label>
                        <textarea class="form-control content1"  name="deskripsi_singkat" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-fotofakultas">Foto Fakultas</label>
                        <input type="file" class="form-control"  name="fotofakultas">
                        
                    </div>
                    <div class="form-group">
                        <label for="edit-akreditasi">Akreditasi</label>
                        <select class="form-control"  name="akreditasi" required>
                            <option value="#">--pilih akreditasi--</option>
                            <option value="Unggul">Unggul</option>
                            <option value="Baik Sekali">Baik Sekali</option>
                            <option value="Baik">Baik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-dekan_id">Dekan</label>
                        <select class="form-control" name="dekan_id" required>
                            <option value="#">--pilih--</option>
                            @foreach($pegawaiss as $pegawai)
                            <option value="{{ $pegawai->id }}">{{ $pegawai->namadekan }}</option>
                            @endforeach
                        </select>
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

<!-- Modal Edit Fakultas -->
<div class="modal fade" id="editFakultasModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editFakultasForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Fakultas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="form-group">
                        <label for="edit-namafakultas">Nama Fakultas</label>
                        <input type="text" class="form-control" id="edit-namafakultas" name="namafakultas" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-visi">Visi</label>
                        <textarea class="form-control" id="edit-visi" name="visi" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-misi">Misi</label>
                        <textarea class="form-control content" id="edit-misi" name="misi" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-deskripsi_singkat">Deskripsi Singkat</label>
                        <textarea class="form-control content1" id="edit-deskripsi_singkat" name="deskripsi_singkat" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-fotofakultas">Foto Fakultas</label>
                        <input type="file" class="form-control" id="edit-fotofakultas" name="fotofakultas">
                        <img id="edit-fotofakultas-preview" src="" alt="Foto Fakultas" style="max-width: 100%; max-height: 200px; display:none;">
                    </div>
                    <div class="form-group">
                        <label for="edit-akreditasi">Akreditasi</label>
                        <select class="form-control" id="edit-akreditasi" name="akreditasi" required>
                            <option value="Unggul">Unggul</option>
                            <option value="Baik Sekali">Baik Sekali</option>
                            <option value="Baik">Baik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-dekan_id">Dekan</label>
                        <select class="form-control" id="edit-dekan_id" name="dekan_id" required>
                            @foreach($pegawaiss as $pegawai)
                            <option value="{{ $pegawai->id }}">{{ $pegawai->namadekan }}</option>
                            @endforeach
                        </select>
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
        $('#fakultas-table').DataTable({
            responsive: true,
            // scrollX: true,
            autoWidth: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('fakultas-inisma.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'fotofakultas',
                    name: 'fotofakultas',
                },
                {
                    data: 'namafakultas',
                    name: 'namafakultas'
                },
            //     {
            //     data: 'visi',
            //     name: 'visi',
            //     render: function(data) {
            //         return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
            //     }
            // },
                // {
                // data: 'misi',
                // name: 'misi',
                // render: function(data) {
                //     // Menghapus HTML dan hanya menampilkan teks
                //     var div = document.createElement("div");
                //     div.innerHTML = data;
                //     return div.textContent || div.innerText || "";
                // }
            // },
                {
                    data: 'akreditasi',
                    name: 'akreditasi'
                },
                {
                    data: 'dekan',
                    name: 'dekan'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [
                [0, 'desc']
            ]
        });
        // Fungsi untuk menyimpan fakultas baru
        $('#createFakultasForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('fakultas-inisma.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire('Success', response.success, 'success');
                    $('#createFakultasModal').modal('hide');
                    location.reload(); // Reload halaman
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Terjadi kesalahan!', 'error');
                }
            });
        });
       
    // Inisialisasi Summernote untuk misi dan deskripsi singkat
   
        // Edit fakultas modal
        $(document).on('click', '.edit-fakultas', function() {
            let fakultasId = $(this).data('id');
            let url = "{{ route('fakultas-inisma.edit', ':id') }}".replace(':id', fakultasId);

            $.get(url, function(data) {
                $('#edit-id').val(data.id);
                $('#edit-namafakultas').val(data.namafakultas);
                $('#edit-visi').val(data.visi);
                $('#edit-misi').summernote('code',data.misi);
                $('#edit-deskripsi_singkat').summernote('code',data.deskripsi_singkat);
                $('#edit-akreditasi').val(data.akreditasi);
                $('#edit-dekan_id').val(data.dekan_id);
                // Jika ada foto fakultas, tampilkan di modal
                if (data.fotofakultas) {
                    // Menampilkan foto yang sudah diupload
                    $('#edit-fotofakultas-preview').attr('src', '/' + data.fotofakultas).show();
                } else {
                    // Jika tidak ada foto, sembunyikan preview
                    $('#edit-fotofakultas-preview').hide();
                }

                // Tampilkan modal
                $('#editFakultasModal').modal('show');

            });
        });

        // Submit form edit
        $('#editFakultasForm').on('submit', function(e) {
            e.preventDefault();
            let fakultasId = $('#edit-id').val();
            let url = "{{ route('fakultas-inisma.update', ':id') }}".replace(':id', fakultasId);
            let formData = new FormData(this);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#editFakultasModal').modal('hide');
                    $('#fakultas-table').DataTable().ajax.reload();
                    Swal.fire('Success', 'Data Fakultas berhasil diubah', 'success');
                },
                error: function(response) {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            });
        });

        // Delete fakultas
        $(document).on('click', '.delete-btn', function() {
            let fakultasId = $(this).data('id');
            let url = "{{ route('fakultas-inisma.destroy', ':id') }}".replace(':id', fakultasId);

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data fakultas ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#fakultas-table').DataTable().ajax.reload();
                            Swal.fire('Deleted!', 'Data fakultas berhasil dihapus.', 'success');
                        },
                        error: function(response) {
                            Swal.fire('Error', 'Terjadi kesalahan', 'error');
                        }
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