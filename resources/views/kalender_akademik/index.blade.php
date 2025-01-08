@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Kalender Akademik</h3>
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
                    <a href="/kalender-akademik">Kalender Akademik</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-primary mb-3 btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#createKalenderAkademikModal">
                                <i class="fas fa-plus"></i> Tambah Kalender Akademik
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Form Filter -->
                        <form id="filterForm" class="mb-4">
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <select name="tahun_akademik_id" id="tahunAkademikSelect" class="form-control" required>
                                        <option value="">Pilih Tahun Akademik</option>
                                        @foreach($tahunAkademik as $tahun)
                                            <option value="{{ $tahun->id }}">{{ $tahun->nama_tahun }} - {{ $tahun->semester }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-danger" id="downloadPDF"> <b class="fas fa-file-pdf"></b> Unduh PDF</button>
                                    <button type="button" class="btn btn-success" id="downloadExcel"> <b class="fas fa-file-excel"></b> Unduh Excel</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table id="kalenderAkademikTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Tahun Akademik</th>
                                        <th>Nama Event</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Deskripsi</th>
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
<div class="modal fade" id="createKalenderAkademikModal" tabindex="-1" aria-labelledby="createKalenderAkademikModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Ukuran modal diperbesar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createKalenderAkademikModalLabel">Tambah Kalender Akademik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createKalenderAkademikForm" action="{{ route('kalender-akademik.store') }}" method="POST">
                    @csrf
                    <div id="dynamicInputFields">
                        <div class="input-group mb-3">
                            <select name="tahun_akademik_id[]" class="form-control" required>
                                <option value="">Pilih Tahun Akademik</option>
                                @foreach($tahunAkademik as $tahun)
                                    <option value="{{ $tahun->id }}">{{ $tahun->nama_tahun }} - {{ $tahun->semester }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="nama_event[]" class="form-control" placeholder="Nama Event" required>
                            <input type="date" name="tanggal_mulai[]" class="form-control" required>
                            <input type="date" name="tanggal _selesai[]" class="form-control" placeholder="Tanggal Selesai">
                            <input type="text" name="deskripsi[]" class="form-control" placeholder="Deskripsi">
                            <button class="btn btn-danger remove" type="button">Hapus</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="addMore">Tambah Input</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="createKalenderAkademikForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editKalenderAkademikModal" tabindex="-1" aria-labelledby="editKalenderAkademikModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Ukuran modal diperbesar -->
        <div class="modal-content">
            <form id="editKalenderAkademikForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editKalenderAkademikModalLabel">Edit Kalender Akademik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="kalenderAkademikId">
                    <div class="mb-3">
                        <label for="editTahunAkademik" class="form-label">Tahun Akademik</label>
                        <select class="form-control" id="editTahunAkademik" name="tahun_akademik_id" required>
                            @foreach($tahunAkademik as $tahun)
                                <option value="{{ $tahun->id }}">{{ $tahun->nama_tahun }} - {{ $tahun->semester }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editNamaEvent" class="form-label">Nama Event</label>
                        <input type="text" class="form-control" id="editNamaEvent" name="nama_event" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTanggalMulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="editTanggalMulai" name="tanggal_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTanggalSelesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="editTanggalSelesai" name="tanggal_selesai">
                    </div>
                    <div class="mb-3">
                        <label for="editDeskripsi" class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" id="editDeskripsi" name="deskripsi">
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
        let table = $('#kalenderAkademikTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('kalender-akademik.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'tahun_akademik', name: 'tahun_akademik' },
                { data: 'nama_event', name: 'nama_event' },
                { data: 'tanggal_mulai', name: 'tanggal_mulai' },
                { data: 'tanggal_selesai', name: 'tanggal_selesai' },
                { data: 'deskripsi', name: 'deskripsi' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Add more input fields
        $('#addMore').click(function() {
            $('#dynamicInputFields').append(`
                <div class="input -group mb-3">
                    <select name="tahun_akademik_id[]" class="form-control" required>
                        <option value="">Pilih Tahun Akademik</option>
                        @foreach($tahunAkademik as $tahun)
                            <option value="{{ $tahun->id }}">{{ $tahun->nama_tahun }} - {{ $tahun->semester }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="nama_event[]" class="form-control" placeholder="Nama Event" required>
                    <input type="date" name="tanggal_mulai[]" class="form-control" required>
                    <input type="date" name="tanggal_selesai[]" class="form-control" placeholder="Tanggal Selesai">
                    <input type="text" name="deskripsi[]" class="form-control" placeholder="Deskripsi">
                    <button class="btn btn-danger remove" type="button">Hapus</button>
                </div>
            `);
        });

        // Remove input fields
        $(document).on('click', '.remove', function() {
            $(this).closest('.input-group').remove();
        });

        // Delete functionality
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            let url = "{{ route('kalender-akademik.destroy', ':id') }}".replace(':id', id);
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
        $('#createKalenderAkademikForm').on('submit', function(e) {
            e.preventDefault();
            $.post("{{ route('kalender-akademik.store') }}", $(this).serialize(), function(response) {
                $('#createKalenderAkademikModal').modal('hide');
                table.ajax.reload();
                Swal.fire('Sukses!', 'Data berhasil ditambahkan.', 'success');
            }).fail(function() {
                Swal.fire('Error!', 'Terjadi kesalahan saat menambahkan data.', 'error');
            });
        });

        // Edit functionality
        $(document).on('click', '.edit-kalender', function() {
            let id = $(this).data('id');
            $.get("{{ url('kalender-akademik') }}/" + id + "/edit", function(data) {
                $('#kalenderAkademikId').val(data.id);
                $('#editTahunAkademik').val(data.tahun_akademik_id);
                $('#editNamaEvent').val(data.nama_event);
                $('#editTanggalMulai').val(data.tanggal_mulai);
                $('#editTanggalSelesai').val(data.tanggal_selesai);
                $('#editDeskripsi').val(data.deskripsi);
                $('#editKalenderAkademikModal').modal('show');
            });
        });

        $('#editKalenderAkademikForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#kalenderAkademikId').val();
            let url = "/kalender-akademik/" + id;
            $.ajax({
                url: url,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    tahun_akademik_id: $('#editTahunAkademik').val(),
                    nama_event: $('#editNamaEvent').val(),
                    tanggal_mulai: $('#editTanggalMulai').val(),
                    tanggal_selesai: $('#editTanggalSelesai').val(),
                    deskripsi: $('#editDeskripsi').val()
                },
                success: function(response) {
                    $('#editKalenderAkademikModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Sukses!', 'Data berhasil diperbarui.', 'success');
                },
                error: function() {
                    Swal.fire('Error!', 'Terjadi kesalahan saat memperbarui data.', 'error');
                }
            });
        });

        // Download PDF functionality
        $('#downloadPDF').click(function() {
            let tahunAkademikId = $('#tahunAkademikSelect ').val();
            if (tahunAkademikId) {
                window.location.href = "{{ route('kalender-akademik.download.pdf') }}?tahun_akademik_id=" + tahunAkademikId;
            } else {
                Swal.fire('Peringatan!', 'Silakan pilih tahun akademik terlebih dahulu.', 'warning');
            }
        });

        // Download Excel functionality
        $('#downloadExcel').click(function() {
            let tahunAkademikId = $('#tahunAkademikSelect').val();
            if (tahunAkademikId) {
                window.location.href = "{{ route('kalender-akademik.download.excel') }}?tahun_akademik_id=" + tahunAkademikId;
            } else {
                Swal.fire('Peringatan!', 'Silakan pilih tahun akademik terlebih dahulu.', 'warning');
            }
        });
    });
</script>
@endpush