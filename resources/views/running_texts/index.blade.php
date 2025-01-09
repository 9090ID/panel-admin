@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Running Text</h3>
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
                    <a href="/running_texts">Running Text</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary mb-3 btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#createRunningTextModal">
                                <i class="fas fa-plus"></i> Tambah Running Text
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="runningTextTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Judul</th>
                                        <!-- <th>Isi</th> -->
                                        <th>Slug</th>
                                        <th>Status</th>
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
<div class="modal fade" id="createRunningTextModal" tabindex="-1" aria-labelledby="createRunningTextModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRunningTextModalLabel">Tambah Running Text</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createRunningTextForm" action="{{ route('running_texts.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="judul">Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="isi">Isi</label>
                        <textarea name="isi" id="isi" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="createRunningTextForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editRunningTextModal" tabindex="-1" aria-labelledby="editRunningTextModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editRunningTextForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editRunningTextModalLabel">Edit Running Text</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="runningTextId">
                    <div class="mb-3">
                        <label for="editJudul" class="form-label">Judul</label>
 <input type="text" class="form-control" id="editJudul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="editIsi" class="form-label">Isi</label>
                        <textarea class="form-control" id="editIsi" name="isi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-control" id="editStatus" name="status" required>
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                        </select>
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
        let table = $('#runningTextTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('running_texts.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {
                data: 'judul',
                name: 'judul',
                render: function(data) {
                    return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
                }
            },
            {
                data: 'slug',
                name: 'slug',
                render: function(data) {
                    return '<div style="white-space: normal; word-wrap: break-word;">' + data + '</div>';
                }
            },
                // { data: 'slug', name: 'slug' },
                { data: 'status', name: 'status' },
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
            let url = "{{ route('running_texts.destroy', ':id') }}".replace(':id', id);
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
        $('#createRunningTextForm').on('submit', function(e) {
            e.preventDefault();
            $.post("{{ route('running_texts.store') }}", $(this).serialize(), function(response) {
                $('#createRunningTextModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Sukses!', 'Data berhasil ditambahkan.', 'success');
            }).fail(function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat menambahkan data.', 'error');
            });
        });

        // Edit functionality
        $(document).on('click', '.edit-running-text', function() {
            let id = $(this).data('id');
            $.get("{{ url('running_texts') }}/" + id + "/edit", function(data) {
                $('#runningTextId').val(data.id);
                $('#editJudul').val(data.judul);
                $('#editIsi').val(data.isi);
                $('#editStatus').val(data.status);
                $('#editRunningTextModal').modal('show');
            });
        });

        $('#editRunningTextForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#runningTextId').val();
            let url = "/running_texts/" + id;
            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    judul: $('#editJudul').val(),
                    isi: $('#editIsi').val(),
                    status: $('#editStatus').val()
                },
                success: function(response) {
                    $('#editRunningTextModal').modal('hide');
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