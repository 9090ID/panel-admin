@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Jabatan</h3>
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
                    <a href="/jabatan">Jabatan</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary mb-3 btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#createJabatanModal">
                                <i class="fas fa-plus"></i> Tambah Jabatan
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="jabatan-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Jabatan</th>
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
<div class="modal fade" id="createJabatanModal" tabindex="-1" aria-labelledby="createJabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createJabatanModalLabel">Tambah Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createJabatanForm" action="{{ route('jabatan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="namajabatan">Nama Jabatan</label>
                        <input type="text" name="namajabatan" id="namajabatan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="aktif">Aktif</option>
                            <option value="non_aktif">Non Aktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="createJabatanForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editJabatanModal" tabindex="-1" aria-labelledby="editJabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editJabatanForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editJabatanModalLabel">Edit Jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="jabatanId">
                    <div class="mb-3">
                        <label for="editNamaJabatan" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="editNamaJabatan" name="namajabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select name="status" id="editStatus" class="form-control" required>
                            <option value="aktif">Aktif</option>
                            <option value="non_aktif">Non Aktif</option>
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
    $(function() {
        let table = $('#jabatan-table').DataTable({
            responsive: true,
            scrollX: true,
            autoWidth: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('jabatan.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'namajabatan', name: 'namajabatan' },
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
            let url = "{{ route('jabatan.destroy', ':id') }}".replace(':id', id);
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
        $('#createJabatanForm').on('submit', function(e) {
            e.preventDefault();
            $.post("{{ route('jabatan.store') }}", $(this).serialize(), function(response) {
                $('#createJabatanModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Sukses!', 'Data berhasil ditambahkan.', 'success');
            }).fail(function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat menambahkan data.', 'error');
            });
        });

        // Edit functionality
        $(document).on('click', '.edit-jabatan', function() {
            let id = $(this).data('id');
            $.get("{{ url('jabatan') }}/" + id + "/edit", function(data) {
                $('#jabatanId').val(data.id);
                $('#editNamaJabatan').val(data.namajabatan);
                $('#editStatus').val(data.status);
                $('#editJabatanModal').modal('show');
            });
        });

        $('#editJabatanForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#jabatanId').val();
            let url = "/jabatan/" + id;
            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    namajabatan: $('#editNamaJabatan').val(),
                    status: $('#editStatus').val()
                },
                success: function(response) {
                    $('#editJabatanModal').modal('hide');
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
