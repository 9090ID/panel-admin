@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Video</h3>
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
                    <a href="/videos">Video</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary mb-3 btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#createVideoModal">
                                <i class="fas fa-plus"></i> Tambah Video
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="videoTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Judul</th>
                                        <th>URL Video</th>
                                        <th>Slug</th>
                                        <th style="width: 10%">Action</th>
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

<!-- Modal Tambah -->
<div class="modal fade" id="createVideoModal" tabindex="-1" aria-labelledby="createVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createVideoModalLabel">Tambah Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createVideoForm" action="{{ route('videos.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="urlvideo">URL Video</label>
                        <input type="text" name="urlvideo" id="urlvideo" class="form-control" required>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="createVideoForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editVideoModal" tabindex="-1" aria-labelledby="editVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editVideoForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editVideoModalLabel">Edit Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="videoId">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUrlVideo" class="form-label">URL Video</label>
                        <input type="text" class="form-control" id="editUrlVideo" name="urlvideo" required>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function() {
        let table = $('#videoTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('videos.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {
                data: 'title',
                name: 'title',
                render: function(data) {
                    return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
                }
            },
                { data: 'urlvideo', name: 'urlvideo' },
                {
                data: 'slug',
                name: 'slug',
                render: function(data) {
                    return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
                }
            },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Delete functionality
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            let url = "{{ route('videos.destroy', ':id') }}".replace(':id', id);
            Swal.fire({
                title: 'Yakin ingin menghapus data ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            table.ajax.reload();
                            Swal.fire('Sukses!', response.message, 'success');
                        },
                        error: function() {
                            Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    });
                }
            });
        });

        // Tambah functionality
        $('#createVideoForm').on('submit', function(e) {
            e.preventDefault();
            $.post("{{ route('videos.store') }}", $(this).serialize(), function(response) {
                $('#createVideoModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Sukses!', 'Data berhasil ditambahkan.', 'success');
            }).fail(function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat menambahkan data.', 'error');
            });
        });

        // Edit functionality
        $(document).on('click', '.edit-video', function() {
            let id = $(this).data('id');
            $.get("{{ url('videos') }}/" + id + "/edit", function(data) {
                $('#videoId').val(data.id);
                $('#editTitle').val(data.title);
                $('#editUrlVideo').val(data.urlvideo);
                $('#editSlug').val(data.slug);
                $('#editVideoModal').modal('show');
            });
        });

        $('#editVideoForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#videoId').val();
            let url = "/videos/" + id;
            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    title: $('#editTitle').val(),
                    urlvideo: $('#editUrlVideo').val(),
                    slug: $('#editSlug').val()
                },
                success: function(response) {
                    $('#editVideoModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Sukses!', 'Data berhasil diperbarui.', 'success');
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat memperbarui data.', 'error');
                }
            });
        });
    });
</script>
@endpush