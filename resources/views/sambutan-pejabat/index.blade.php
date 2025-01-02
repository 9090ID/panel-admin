@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Data Sambutan Pejabat</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('sambutan-pejabat.index') }}">
                        <i class="icon-user"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sambutan-pejabat.index') }}">Sambutan Pejabat</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sambutan-pejabat.index') }}">Data Sambutan</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('sambutan-pejabat.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i> Tambah Sambutan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="sambutan-pejabat-table" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Pejabat</th>
                                        <th>Jabatan</th>
                                        <th>Lama Menjabat</th>
                                        <th>Image</th>
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

<!-- Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Detail Sambutan Pejabat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Pejabat:</strong> <span id="modalNamaPejabat"></span></p>
                <p><strong>Jabatan:</strong> <span id="modalNamaJabatan"></span></p>
                <p><strong>Riwayat Hidup:</strong></p>
                <p id="modalRiwayatHidup"></p>
                <p><strong>Isi Sambutan:</strong></p>
                <p id="modalIsiSambutan"></p>
                <p><strong>Foto Pejabat:</strong></p>
                <img id="modalFotoPejabat" src="" alt="Foto Pejabat" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        // Inisialisasi DataTable
        $('#sambutan-pejabat-table').DataTable({
            responsive: true,
            scrollX: true,
            autoWidth: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('sambutan-pejabat.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'namapejabat', name: 'namapejabat' }, // Nama Pejabat
                { data: 'namajabatan', name: 'namajabatan' }, // Nama Pejabat
                { data: 'totalmenjabat', name: 'totalmenjabat' }, // Lama Menjabat
                { data: 'fotopejabat', name: 'fotopejabat' }, // Isi Sambutan
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Hapus data sambutan pejabat dengan konfirmasi
        $(document).on('click', '.delete-btn', function() {
            let sambutanId = $(this).data('id');
            let url = "{{ route('sambutan-pejabat.destroy', ':id') }}".replace(':id', sambutanId);

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
                            $('#sambutan-pejabat-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', xhr.responseJSON?.error || 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        });
    });

    $(document).on('click', '.view-btn', function() {
    const sambutanId = $(this).data('id');
    const url = "{{ route('sambutan-pejabat.show', ':id') }}".replace(':id', sambutanId);

    // Mengambil data melalui AJAX
    $.get(url, function(data) {
        // Menampilkan data ke dalam modal
        $('#modalNamaPejabat').text(data.sambutanPejabat.pegawai.namadekan || '-');
        $('#modalNamaJabatan').text(data.sambutanPejabat.jabatan.namajabatan || '-');
        $('#modalRiwayatHidup').html(data.sambutanPejabat.riwayathidup || '-');
        $('#modalIsiSambutan').html(data.sambutanPejabat.isisambutan || '-');

        // Menampilkan foto pejabat (jika ada)
        if (data.sambutanPejabat.fotopejabat) {
            $('#modalFotoPejabat').attr('src', data.sambutanPejabat.fotopejabat)
            .css({
                'max-width': '150px',
                'height': 'auto',
                'border': '2px solid #ddd',
                'border-radius': '5px',
                'margin-bottom': '10px'
            });
        } else {
            $('#modalFotoPejabat').attr('src', '#').css('border', 'none');
        }

        // Menampilkan modal
        $('#viewModal').modal('show');
    });
});
</script>
@endpush
