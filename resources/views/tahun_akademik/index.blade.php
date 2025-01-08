@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Tahun Akademik</h3>
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
                    <a href="/tahun-akademik">Tahun Akademik</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary mb-3 btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#createTahunAkademikModal">
                                <i class="fas fa-plus"></i> Tambah Tahun Akademik
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tahunAkademikTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Tahun</th>
                                        <th>Semester</th>
                                        <th>Aktif</th>
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
<div class="modal fade" id="createTahunAkademikModal" tabindex="-1" aria-labelledby="createTahunAkademikModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTahunAkademikModalLabel">Tambah Tahun Akademik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createTahunAkademikForm" action="{{ route('tahun-akademik.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_tahun">Nama Tahun (Contoh: 2024-2025):</label>
                        <input type="text" name="nama_tahun" id="nama_tahun" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester:</label>
                        <select name="semester" id="semester" class="form-control" required>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="aktif">Aktif:</label>
                        <input type="checkbox" name="aktif" id="aktif" value="1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="createTahunAkademikForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editTahunAkademikModal" tabindex="-1" aria-labelledby="editTahunAkademikModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editTahunAkademikForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editTahunAkademikModalLabel">Edit Tahun Akademik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </ div>
                <div class="modal-body">
                    <input type="hidden" id="tahunAkademikId">
                    <div class="mb-3">
                        <label for="editNamaTahun" class="form-label">Nama Tahun</label>
                        <input type="text" class="form-control" id="editNamaTahun" name="nama_tahun" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSemester" class="form-label">Semester</label>
                        <select class="form-control" id="editSemester" name="semester" required>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editAktif" class="form-label">Aktif</label>
                        <input type="checkbox" class="form-check-input" id="editAktif" name="aktif" value="1">
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
        let table = $('#tahunAkademikTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('tahun-akademik.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama_tahun', name: 'nama_tahun' },
                { data: 'semester', name: 'semester' },
                { data: 'aktif', name: 'aktif', render: function(data) {
                    return data ? 'Ya' : 'Tidak';
                }},
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
            let url = "{{ route('tahun-akademik.destroy', ':id') }}".replace(':id', id);
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
        $('#createTahunAkademikForm').on('submit', function(e) {
            e.preventDefault();
            $.post("{{ route('tahun-akademik.store') }}", $(this).serialize(), function(response) {
                $('#createTahunAkademikModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Sukses!', 'Data berhasil ditambahkan.', 'success');
            }).fail(function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat menambahkan data.', 'error');
            });
        });

        // Edit functionality
        $(document).on('click', '.edit-tahun-akademik', function() {
            let id = $(this).data('id');
            $.get("{{ url('tahun-akademik') }}/" + id + "/edit", function(data) {
                $('#tahunAkademikId').val(data.id);
                $('#editNamaTahun').val(data.nama_tahun);
                $('#editSemester').val(data.semester);
                $('#editAktif').prop('checked', data.aktif);
                $('#editTahunAkademikModal').modal('show');
            });
        });

        $('#editTahunAkademikForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#tahunAkademikId').val();
            let url = "/tahun-akademik/" + id;
            $.ajax ({
                url: url,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    nama_tahun: $('#editNamaTahun').val(),
                    semester: $('#editSemester').val(),
                    aktif: $('#editAktif').is(':checked') ? 1 : 0
                },
                success: function(response) {
                    $('#editTahunAkademikModal').modal('hide');
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